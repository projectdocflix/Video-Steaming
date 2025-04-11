<?php

namespace App\Http\Services\Payment;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class CinetPayService
{
    private $apiUrl;
    private $apiKey;
    private $siteId;
    private $currency;
    private $successUrl;
    private $cancelUrl;

    private $currency;

    public function __construct($object)
    {
        // Fetch settings dynamically from configuration (get_option or similar)
        $this->apiUrl = 'https://api-checkout.cinetpay.com/v2/payment';
        $this->apiKey = get_option('cinetpay_key');  // CinetPay's API Key
        $this->siteId = get_option('cinetpay_secret');  // CinetPay's Site ID
        $this->currency = isset($object['currency']) ? $object['currency'] : 'XOF';  // Set default currency as XOF (CFA Franc)

        // Set successUrl and cancelUrl from the object, or use default routes
        if (isset($object['id'])) {
            $this->successUrl = isset($object['successUrl']) ? $object['successUrl'] : route('paymentNotify', $object['id']);
            $this->cancelUrl = isset($object['cancelUrl']) ? $object['cancelUrl'] : route('paymentCancel', $object['id']);
        }
    }

    public function makePayment($amount)
    {
        $transaction_id = uniqid();  // Generate a unique transaction ID

        // Prepare the payload according to CinetPay's API requirements
        $payload = [
            'amount' => (int)($amount * 100),  // Convert amount to minor units
            'currency' => $this->currency,  // Currency for the payment
            'transaction_id' => $transaction_id,  // Unique transaction ID
            'customer_name' => Auth::user()->name,  // Customer's name
            'customer_email' => Auth::user()->email,  // Customer's email
            'description' => 'Purchase',  // Description of the payment
            'return_url' => $this->successUrl,  // URL to redirect after successful payment
            'cancel_url' => $this->cancelUrl,  // URL to redirect if payment is canceled
            'site_id' => $this->siteId,  // CinetPay's site ID
            'apikey' => $this->apiKey,  // CinetPay's API key
        ];

        // Make the request to CinetPay API
        $response = Http::post($this->apiUrl, $payload);

        // Log the response for debugging
        Log::info('<<<< CinetPay Response >>>>');
        Log::info(json_encode($response->json()));

        $data = [
            'success' => false,
            'redirect_url' => '',
            'payment_id' => '',
            'message' => __('Something went wrong'),
        ];

        try {
            $responseData = $response->json();
            if ($response->status() == 201 && isset($responseData['data']['payment_url'])) {  // Check if the request was successful
                $data['redirect_url'] = $responseData['data']['payment_url'];
                $data['payment_id'] = $transaction_id;
                $data['success'] = true;
            }
            return $data;
        } catch (\Exception $ex) {
            $data['message'] = $ex->getMessage();
            return $data;
        }
    }

    public function paymentConfirmation($payment_id)
    {
        $data = [
            'success' => false,
            'data' => null,
        ];

        // Prepare the payload for verifying the payment
        $payload = [
            'transaction_id' => $payment_id,
            'site_id' => $this->siteId,
            'apikey' => $this->apiKey,
        ];

        $url = "https://api-checkout.cinetpay.com/v2/payment/check";

        // Make the request to CinetPay to verify the payment status
        $response = Http::post($url, $payload);

        // Check if the API response is successful
        if ($response->successful()) {
            $responseData = $response->json();
            if (isset($responseData['code']) && $responseData['code'] == '00' && isset($responseData['data']['status']) && $responseData['data']['status'] == 'ACCEPTED') {
                // Payment was successful
                $data['success'] = true;
                $data['data'] = [
                    'amount' => $responseData['data']['amount'],
                    'currency' => $responseData['data']['currency'],
                    'payment_status' => 'success',
                    'payment_method' => $responseData['data']['payment_method'],
                    'payment_date' => $responseData['data']['payment_date'],
                    'operator_id' => $responseData['data']['operator_id'],
                ];
            } else {
                $data['message'] = 'Payment not accepted';
            }
        } else {
            $data['message'] = 'Failed to verify payment';
        }

        return $data;
    }
}
