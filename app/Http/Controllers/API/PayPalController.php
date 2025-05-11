<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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
            
            // Obtain the access token
            $accessToken = $this->getAccessToken();
            
            // Capture the payment using the PayPal API
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer {$accessToken}"
            ])->post("{$this->baseUrl}/v2/checkout/orders/{$orderId}/capture");
            
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
            
            if (isset($captureData['status']) && $captureData['status'] === 'COMPLETED') {
                $order->status = 'paid';
                $order->save();

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