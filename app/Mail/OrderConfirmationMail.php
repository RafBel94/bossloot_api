<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Http\Services\CurrencyExchangeService;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailData;
    public $imageUrl;

    /**
     * Create a new message instance.
     *
     * @param array $emailData
     * @param string|null $imageUrl
     * @return void
     */
    public function __construct(array $emailData)
    {
        $this->emailData = $emailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Prepare converted prices for each item
        $convertedPrices = [];
        $order = null;
        $currency = $this->emailData['currency'] ?? 'EUR';
        $calculatedTotal = 0; // To calculate the total from the converted items
        
        // Check if we have access to the order items
        if (isset($this->emailData['items']) && !empty($this->emailData['items'])) {
            foreach ($this->emailData['items'] as $item) {
                if (!$order && isset($item->order) && $item->order) {
                    $order = $item->order;
                }
                
                if ($order) {
                    $conversionRate = $order->getConversionRate();
                    $convertedUnitPrice = $item->getConvertedUnitPrice($order->currency, $conversionRate);
                    $convertedTotalPrice = $item->getConvertedTotalPrice($order->currency, $conversionRate);
                    
                    $convertedPrices[$item->id] = [
                        'unit_price' => $convertedUnitPrice,
                        'total_price' => $convertedTotalPrice
                    ];
                    
                    $calculatedTotal += $convertedTotalPrice;
                } else {
                    $exchangeService = app(CurrencyExchangeService::class);
                    $convertedUnitPrice = $exchangeService->convert($item->unit_price, 'EUR', $currency) ?? $item->unit_price;
                    $convertedTotalPrice = $exchangeService->convert($item->total_price, 'EUR', $currency) ?? $item->total_price;
                    
                    $convertedPrices[$item->id] = [
                        'unit_price' => $convertedUnitPrice,
                        'total_price' => $convertedTotalPrice
                    ];
                    
                    // Accumulate the converted total
                    $calculatedTotal += $convertedTotalPrice;
                }
            }
        }
        
        // Calculate the converted total
        $totalAmount = $this->emailData['total_amount'] ?? 0;
        
        if ($order) {
            $apiConvertedTotal = $order->getConvertedTotal();
            
            // If the difference between the calculated total and the converted total is significant
            // (more than 1% difference), use the calculated total for greater consistency
            $difference = abs($calculatedTotal - $apiConvertedTotal) / $apiConvertedTotal;
            $convertedTotal = ($difference > 0.01) ? $calculatedTotal : $apiConvertedTotal;
        } else if ($totalAmount > 0 && $currency !== 'EUR') {
            $exchangeService = app(CurrencyExchangeService::class);
            $apiConvertedTotal = $exchangeService->convert($totalAmount, 'EUR', $currency) ?? $totalAmount;
            
            $difference = abs($calculatedTotal - $apiConvertedTotal) / $apiConvertedTotal;
            $convertedTotal = ($difference > 0.01) ? $calculatedTotal : $apiConvertedTotal;
        } else {
            $convertedTotal = $calculatedTotal;
        }
        
        // Log values for debugging
        \Log::info('Mail conversion details', [
            'calculatedTotal' => $calculatedTotal,
            'apiConvertedTotal' => $apiConvertedTotal ?? 'Not available',
            'finalTotal' => $convertedTotal,
            'items' => count($convertedPrices)
        ]);

        $mail = $this->subject($this->emailData['subject'])
            ->replyTo($this->emailData['email'], $this->emailData['name'])
            ->view('emails.order_confirmation')
            ->with([
                'name' => $this->emailData['name'],
                'email' => $this->emailData['email'],
                'subject' => $this->emailData['subject'],
                'messageContent' => $this->emailData['message'],
                'items' => $this->emailData['items'],
                'total_amount' => $totalAmount,
                'convertedTotal' => $convertedTotal,
                'convertedPrices' => $convertedPrices,
                'currency' => $currency,
            ]);

        return $mail;
    }
}