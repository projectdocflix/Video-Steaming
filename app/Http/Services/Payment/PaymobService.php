<?php

namespace App\Http\Services\Payment;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymobService
{
    private $apiUrl;
    private $apiKey;
    private $integrationId;
    public $currency;
    public $provider;
    private $successUrl;
    private $cancelUrl;

    public function __construct($object)
    {
        $this->apiUrl = 'https://accept.paymobsolutions.com/api';
        $this->provider = $object['payment_method'];
        $this->apiKey = get_option($this->provider.'_key');
        $this->integrationId = get_option($this->provider.'_secret');
        $this->currency = $object['currency'] ?? 'EGP'; // Default currency if not provided
    }

    public function authenticate()
    {
        $response = Http::post($this->apiUrl . '/auth/tokens', [
            'api_key' => $this->apiKey,
        ]);

        $data = $response->json();

        if ($response->successful() && isset($data['token'])) {
            return $data['token'];
        }

        Log::error('Paymob Authentication Failed: ' . json_encode($data));
        return null;
    }

    public function createOrder($amount)
    {
        $authToken = $this->authenticate();
        if (!$authToken) {
            return null;
        }

        $orderData = [
            'auth_token' => $authToken,
            'delivery_needed' => false,
            'amount_cents' => $amount * 100, // Convert to cents
            'currency' => $this->currency,
            'merchant_order_id' => uniqid(), // Unique order ID
            'items' => [], // Empty items array (optional)
        ];

        $response = Http::post($this->apiUrl . '/ecommerce/orders', $orderData);
        $order = $response->json();

        if ($response->successful() && isset($order['id'])) {
            return $order['id'];
        }

        Log::error('Paymob Order Creation Failed: ' . json_encode($order));
        return null;
    }

    public function generatePaymentKey($orderId, $amount)
    {
        $authToken = $this->authenticate();
        if (!$authToken) {
            return null;
        }

        $paymentKeyData = [
            'auth_token' => $authToken,
            'amount_cents' => $amount * 100, // Convert to cents
            'expiration' => 3600, // Payment key expiration in seconds
            'order_id' => $orderId,
            'billing_data' => [
                'email' => auth()->user()->email,
                'first_name' => auth()->user()->name ?? 'name',
                'last_name' => auth()->user()->name ?? 'name',
                'phone_number' => auth()->user()->mobile ?? '0123456789',
                'city' => auth()->user()->city ?? 'Cairo',
                'country' => auth()->user()->country ?? 'EG',
                'street' => auth()->user()->address ?? '123 Street',
                'building' => 'billing',
                'floor' =>  'floor',
                'apartment' => 'apaet',
            ],
            'currency' => $this->currency,
            'integration_id' => $this->integrationId,
        ];

        $response = Http::post($this->apiUrl . '/acceptance/payment_keys', $paymentKeyData);
        $paymentKey = $response->json();

        if ($response->successful() && isset($paymentKey['token'])) {
            return $paymentKey['token'];
        }

        Log::error('Paymob Payment Key Generation Failed: ' . json_encode($paymentKey));
        return null;
    }

    public function makePayment($amount, $postData = [])
    {
        $orderId = $this->createOrder($amount);

        if (!$orderId) {
            return [
                'success' => false,
                'message' => 'Failed to create order',
            ];
        }

        $paymentKey = $this->generatePaymentKey($orderId, $amount);

        if (!$paymentKey) {
            return [
                'success' => false,
                'message' => 'Failed to generate payment key',
            ];
        }

        return [
            'success' => true,
            'payment_id' => $orderId,
            'redirect_url' => "https://accept.paymobsolutions.com/api/acceptance/iframes/{$this->integrationId}?payment_token={$paymentKey}",
            'message' => 'Redirecting to payment...',
        ];
    }

    public function paymentConfirmation($paymentId, $payerId = null)
    {
        $response = Http::get($this->apiUrl . '/acceptance/transactions/' . $paymentId);

        $data = [
            'success' => false,
            'data' => null,
            'message' => 'Payment not approved',
        ];

        if ($response->successful()) {
            $paymentData = $response->json();

            if ($paymentData['success'] == true) {
                $data['success'] = true;
                $data['data'] = [
                    'payment_status' => 'success',
                    'payment_method' => 'PAYMOB',
                ];
            } else {
                $data['message'] = 'Payment failed';
            }
        } else {
            Log::error('Paymob Payment Confirmation Failed: ' . $response->body());
        }

        return $data;
    }
}
