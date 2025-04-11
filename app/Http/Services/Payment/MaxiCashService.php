<?php

namespace App\Http\Services\Payment;

use Illuminate\Support\Facades\Log;

class MaxiCashService
{
    private $apiUrl;
    private $currency;
    private $successUrl;
    private $cancelUrl;
    private $provider;

    public function __construct($object)
    {
        // Set callback URLs
        $this->cancelUrl = isset($object['cancelUrl']) ? $object['cancelUrl'] : route('paymentCancel', $object['id']);
        $this->successUrl = isset($object['successUrl']) ? $object['successUrl'] : route('paymentNotify', $object['id']);

        // Set currency and payment method from passed object
        $this->currency = $object['currency'];
        $this->provider = $object['payment_method'];

        // Set API URL based on environment mode
        $this->apiUrl = get_option("{$this->provider}_mode") === 'live'
            ? 'https://api.maxicashapp.com/PayEntry?data='
            : 'https://api-testbed.maxicashapp.com/PayEntry?data=';
    }

    public function makePayment($amount)
    {
        // Initialize response structure
        $response = [
            'success' => false,
            'redirect_url' => '',
            'payment_id' => '',
            'message' => __('Something went wrong')
        ];

        // Generate unique order ID and payment ID
        $paymentId = sha1(uniqid());
        $userId = auth()->id();
        $timestamp = time();

        // Create signature using merchant secret
        $signature = hash_hmac('sha256', $userId . '|' . $paymentId . '|' . $timestamp, get_option("{$this->provider}_secret"));

        // Encrypt user ID and timestamp
        $encryptedData = encrypt($userId . '|' . $timestamp);

        // Update callback URL with encrypted data and signature
        $callbackUrlWithData = $this->successUrl . '?data=' . urlencode($encryptedData) . '&signature=' . $signature;

        // Prepare data to send to MaxiCash API
        $data = [
            'PayType' => 'MaxiCash',
            'Amount' => $amount * 100, // Convert to minor units (e.g., cents)
            'Currency' => $this->currency,
            'MerchantID' => get_option("{$this->provider}_key"),
            'MerchantPassword' => get_option("{$this->provider}_secret"),
            'Reference' => $paymentId,
            'Accepturl' => $callbackUrlWithData,
            'Cancelurl' => $this->cancelUrl,
            'Declineurl' => $this->cancelUrl
        ];

        try {
            // Convert data to JSON and create the redirect URL
            $dataJson = json_encode($data);
            $redirectUrl = $this->apiUrl . urlencode($dataJson);

            // Update the response with successful payment details
            $response['payment_id'] = $paymentId;
            $response['redirect_url'] = $redirectUrl;
            $response['success'] = true;

            Log::info('MaxiCash payment request', ['request' => $data]);

        } catch (\Exception $e) {
            // Log and handle errors
            $response['message'] = $e->getMessage();
            Log::error('MaxiCash makePayment Error: ' . $e->getMessage());
        }

        return $response;
    }

    public function paymentConfirmation($paymentId)
    {
        // Initialize response structure
        $data = [
            'success' => false,
            'data' => null,
            'message' => __('Something went wrong during payment confirmation')
        ];

        // Get signature and encrypted data from request
        $signature = request()->query('signature');
        $encryptedData = request()->query('data');

        try {
            // Decrypt data
            $decryptedData = decrypt($encryptedData);
            list($userId, $timestamp) = explode('|', $decryptedData);

            // Verify the signature
            $expectedSignature = hash_hmac('sha256', $userId . '|' . $paymentId . '|' . $timestamp, get_option("{$this->provider}_secret"));

            if (hash_equals($expectedSignature, $signature)) {
                // If signature matches, confirm successful payment
                $data['success'] = true;
                $data['data']['payment_status'] = 'success';
                $data['data']['payment_method'] = MAXICASH;
            } else {
                $data['message'] = 'Signature mismatch';
            }

        } catch (\Exception $e) {
            $data['message'] = 'Invalid or tampered data';
            Log::error('MaxiCash Payment Verification Failed: ' . $e->getMessage());
        }

        return $data;
    }
}
