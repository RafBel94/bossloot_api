<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CurrencyExchangeService
{
    /**
     * API Key for exchangerateapi.com
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Base URL of the API
     *
     * @var string
     */
    protected $baseUrl = 'https://v6.exchangerate-api.com/v6';

    /**
     * Cache time for rates (24 hours by default)
     *
     * @var int
     */
    protected $cacheTime = 86400; // 24 hours in seconds

    /**
     * Create a new instance of the service
     *
     * @return void
     */
    public function __construct()
    {
        $this->apiKey = env('COIN_EXCHANGE_API_KEY');
        
        if (empty($this->apiKey)) {
            Log::warning('COIN_EXCHANGE_API_KEY is not defined in the .env file');
        }
    }

    /**
     * Get exchange rates for a base currency
     *
     * @param string $baseCurrency Base currency (EUR, USD, etc.)
     * @return array|null Exchange rates or null in case of error
     */
    public function getExchangeRates(string $baseCurrency = 'EUR')
    {
        // First, try to get the rates from cache
        $cacheKey = "exchange_rates_{$baseCurrency}";
        
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        
        try {
            $apiUrl = "{$this->baseUrl}/{$this->apiKey}/latest/{$baseCurrency}";
            $response = Http::get($apiUrl);
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['result']) && $data['result'] === 'success') {
                    // Store in cache for future requests
                    $rates = $data['conversion_rates'];
                    Cache::put($cacheKey, $rates, $this->cacheTime);
                    
                    return $rates;
                } else {
                    Log::error('Error in Exchange Rate API response: ' . json_encode($data));
                }
            } else {
                Log::error('Error connecting to Exchange Rate API: ' . $response->status());
            }
            
            return null;
        } catch (\Exception $e) {
            Log::error('Exception while getting exchange rates: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Converts a value from one currency to another
     *
     * @param float $amount Amount to convert
     * @param string $fromCurrency Source currency
     * @param string $toCurrency Target currency
     * @return float|null Converted value or null in case of error
     */
    public function convert(float $amount, string $fromCurrency, string $toCurrency)
    {
        // If they are the same currency, no conversion is needed
        if ($fromCurrency === $toCurrency) {
            return $amount;
        }
        
        $rates = $this->getExchangeRates($fromCurrency);
        
        if (!$rates || !isset($rates[$toCurrency])) {

            if ($fromCurrency !== 'EUR') {
                $eurRates = $this->getExchangeRates('EUR');
                
                if ($eurRates && isset($eurRates[$fromCurrency]) && isset($eurRates[$toCurrency])) {
                    $amountInEur = $amount / $eurRates[$fromCurrency];
                    return $amountInEur * $eurRates[$toCurrency];
                }
            }
            
            Log::warning("Could not convert from {$fromCurrency} to {$toCurrency}");
            return null;
        }
        
        return $amount * $rates[$toCurrency];
    }

    /**
     * Gets the conversion rate between two currencies
     *
     * @param string $fromCurrency Source currency
     * @param string $toCurrency Target currency
     * @return float|null Conversion rate or null in case of error
     */
    public function getRate(string $fromCurrency, string $toCurrency)
    {
        if ($fromCurrency === $toCurrency) {
            return 1.0;
        }
        
        $rates = $this->getExchangeRates($fromCurrency);
        
        if (!$rates || !isset($rates[$toCurrency])) {
            if ($fromCurrency !== 'EUR') {
                $eurRates = $this->getExchangeRates('EUR');
                
                if ($eurRates && isset($eurRates[$fromCurrency]) && isset($eurRates[$toCurrency])) {
                    return $eurRates[$toCurrency] / $eurRates[$fromCurrency];
                }
            }
            
            return null;
        }
        
        return $rates[$toCurrency];
    }

    /**
     * Sets the cache time for the rates
     *
     * @param int $seconds
     * @return $this
     */
    public function setCacheTime(int $seconds)
    {
        $this->cacheTime = $seconds;
        return $this;
    }
}