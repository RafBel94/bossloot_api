<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\Mail\OrderConfirmationMail;

class PayPalController extends BaseController
{
    protected $clientId;
    protected $clientSecret;
    protected $baseUrl;
    
    public function __construct()
    {
        $this->clientId = env('PAYPAL_SANDBOX_CLIENT_ID');
        $this->clientSecret = env('PAYPAL_SANDBOX_CLIENT_SECRET');
        $this->baseUrl = 'https://api-m.sandbox.paypal.com';
    }
    
    public function createOrder($orderId)
    {
        try {
            DB::beginTransaction();

            // Verify that the order belongs to the authenticated user
            $order = Order::where('id', $orderId)
                ->where('user_id', Auth::id())
                ->with('items')
                ->firstOrFail();
            
            // Obtain the access token
            $accessToken = $this->getAccessToken();
            
            // Create the order in PayPal
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer {$accessToken}"
            ])->post("{$this->baseUrl}/v2/checkout/orders", [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => $order->currency,
                            'value' => number_format($order->total_amount, 2, '.', '')
                        ],
                        'description' => "Orden #{$order->id}",
                        'reference_id' => (string) $order->id
                    ]
                ],
                'application_context' => [
                    'return_url' => route('paypal.success'),
                    'cancel_url' => route('paypal.cancel')
                ]
            ]);
            
            // Verify that the response was successful
            if (!$response->successful()) {
                throw new \Exception('PayPal API error: ' . $response->body());
            }
            
            $paypalOrder = $response->json();
            
            // Verify that PayPal returned an order ID
            if (!isset($paypalOrder['id'])) {
                throw new \Exception('PayPal did not return an order ID');
            }
            
            // Save the PayPal order ID in the database
            $order->payment_method = 'paypal';
            $order->payment_id = $paypalOrder['id'];
            $order->save();

            DB::commit();
            
            // Return the PayPal order ID to the frontend
            return $this->sendResponse($paypalOrder, 'PayPal order created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating PayPal order: ' . $e->getMessage());
            return $this->sendError('Error creating PayPal order', ['Failed to create PayPal order: ' . $e->getMessage()], 500);
        }
    }
    
    // This method will be called when the user completes the payment on PayPal
    public function capturePayment(Request $request)
    {
        try {
            DB::beginTransaction();

            $orderId = $request->input('order_id');
            
            // Log the PayPal order ID for debugging
            Log::info('Attempting to capture PayPal payment for order: ' . $orderId);
            
            // Obtain the access token
            $accessToken = $this->getAccessToken();
            
            $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer {$accessToken}"
                ])
                ->withBody('', 'application/json')
                ->post("{$this->baseUrl}/v2/checkout/orders/{$orderId}/capture");
            
            // Log the response for debugging
            Log::info('PayPal capture response: ' . $response->body());
            
            // Verify that the response was successful
            if (!$response->successful()) {
                throw new \Exception('PayPal API error: ' . $response->body());
            }
            
            $captureData = $response->json();
            
            // Update the order status in the database
            $order = Order::where('payment_id', $orderId)->firstOrFail();
            
            // Verify that the order belongs to the authenticated user
            if ($order->user_id !== Auth::id()) {
                throw new \Exception('Unauthorized access to order');
            }
            
            // If the payment was successful, update the order status
            if (isset($captureData['status']) && $captureData['status'] === 'COMPLETED') {
                $order->status = 'paid';
                $order->save();

                // Also update the cart status if needed
                if ($order->cart_id) {
                    $cart = Cart::find($order->cart_id);
                    if ($cart) {
                        $cart->status = 'processed';
                        $cart->save();
                    }
                }
                
                // Load the order items and user for the confirmation email, point assignment and assigning the order to each item
                $order->load('items.order', 'user');

                // // Assign the order to each item (*)
                // foreach ($order->items as $item) {
                //     $item->order = $order;
                // }    
                
                // // Assign the order_id to the item (*)
                // $item->order_id = $order->id;
                // $item->save();

                // Assign points to the user
                $this->assignPoints($order);

                // Send confirmation email
                $this->sendConfirmationEmail($order);

                DB::commit();
                
                return $this->sendResponse($order, 'Payment completed successfully.');
            } else {
                $errorMessage = isset($captureData['message']) 
                    ? $captureData['message'] 
                    : 'Unknown error from PayPal';
                
                DB::rollBack();
                return $this->sendError('Error processing payment', ['Failed to process payment: ' . $errorMessage], 400);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error capturing PayPal payment: ' . $e->getMessage());
            return $this->sendError('Error capturing PayPal payment', ['Failed to capture payment: ' . $e->getMessage()], 500);
        }
    }

    // Method to assign points to the user
    private function assignPoints($order)
    {
        try {
            // Assign points to the user based on the order total
            $user = $order->user;
            $points = $order->total_amount * 0.25;
            $user->points += $points;
            $user->TryLevelUp();
            $user->save();
        } catch (\Exception $e) {
            Log::error('Error assigning points to user: ' . $e->getMessage());
        }
    }

    // Method to send confirmation email
    private function sendConfirmationEmail($order)
    {
        try {
            // Prepare the email data
            $emailData = [
                'name' => $order->user->name,
                'email' => $order->user->email,
                'subject' => 'Confirmación de Pedido #' . $order->id,
                'message' => '¡Gracias por tu compra! Tu pedido ha sido procesado y confirmado. A continuación encontrarás los detalles de tu compra.',
                'items' => $order->items,
                'total_amount' => $order->total_amount,
                'currency' => $order->currency,
            ];

            // Send confirmation email
            Mail::to($order->user->email)->send(new OrderConfirmationMail($emailData));
        } catch (\Exception $e) {
            Log::error('Error sending confirmation email: ' . $e->getMessage());
        }
    }
    
    // Method to get the access token from PayPal
    private function getAccessToken()
    {
        try {
            $response = Http::withBasicAuth($this->clientId, $this->clientSecret)
                ->asForm()
                ->post("{$this->baseUrl}/v1/oauth2/token", [
                    'grant_type' => 'client_credentials'
                ]);
                
            if (!$response->successful()) {
                throw new \Exception('Failed to obtain PayPal access token: ' . $response->body());
            }
            
            $tokenData = $response->json();
            
            if (!isset($tokenData['access_token'])) {
                throw new \Exception('PayPal did not return an access token');
            }
            
            return $tokenData['access_token'];
        } catch (\Exception $e) {
            Log::error('Error obtaining PayPal access token: ' . $e->getMessage());
            throw new \Exception('Error obtaining PayPal access token: ' . $e->getMessage());
        }
    }
    
    // Endpoint for when PayPal redirects back after successful payment
    public function success(Request $request)
    {
        try {
            // Extractar el token de la URL
            $token = $request->input('token');
            
            if ($token) {
                // Optional: You can capture the payment here if you haven't done it automatically
                // $this->capturePayment(new Request(['order_id' => $token]));
            }
            
            return $this->sendResponse(['token' => $token], 'Payment successful.');
        } catch (\Exception $e) {
            Log::error('Error processing PayPal success: ' . $e->getMessage());
            return $this->sendError('Error processing PayPal success', ['error' => $e->getMessage()], 500);
        }
    }
    
    // This method will be called when the user cancels the payment
    public function cancel()
    {
        try {
            return $this->sendResponse([], 'Payment cancelled.');
        } catch (\Exception $e) {
            Log::error('Error processing PayPal cancel: ' . $e->getMessage());
            return $this->sendError('Error processing PayPal cancel', ['error' => $e->getMessage()], 500);
        }
    }
}