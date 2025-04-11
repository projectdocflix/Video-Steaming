<?php

namespace App\Http\Services\Payment;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PayHerePaymentService
{
    private $apiUrl;
    private $merchantId;
    private $merchantSecret;
    private $currency;
    private $successUrl;
    private $cancelUrl;
    private $orderId;
    private $provider;

    public function __construct($object)
    {
        // Set callback URLs
        $this->cancelUrl = isset($object['cancelUrl']) ? $object['cancelUrl'] : route('paymentCancel', $object['id']);
        $this->successUrl = isset($object['successUrl']) ? $object['successUrl'] : route('paymentNotify', $object['id']);

        $this->provider = $object['payment_method'];
        // Set order ID
        $this->orderId = isset($object['id']) ? $object['id'] : null;

        // Set currency and fetch payment gateway details
        $this->currency = $object['currency'];
        $this->merchantId = get_option($this->provider.'_key');
        $this->merchantSecret = get_option($this->provider.'_secret');

        // Set API URL based on environment mode
        $this->apiUrl = get_option($this->provider.'_mode') === 'live'
            ? 'https://www.payhere.lk/pay/checkout'
            : 'https://sandbox.payhere.lk/pay/checkout';
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
        $paymentId = sha1($this->orderId);
        $userId = auth()->id();
        $timestamp = time();

        // Generate the signature (HMAC with secret key)
        $signature = hash_hmac('sha256', $userId . '|' . $paymentId . '|' . $timestamp, $this->merchantSecret);

        // Encrypt user ID and timestamp
        $encryptedData = encrypt($userId . '|' . $timestamp);

        // Update callback URL with encrypted data and signature
        $callbackUrlWithData = $this->successUrl . '?data=' . urlencode($encryptedData) . '&signature=' . $signature;

        // Prepare payload for PayHere
        $payload = [
            'merchant_id' => $this->merchantId,
            'return_url' => $callbackUrlWithData, // Use modified callback URL
            'cancel_url' => $this->cancelUrl,
            'notify_url' => null,
            'order_id' => $paymentId, // Unique order ID
            'items' => 'Order Payment', // Order description
            'currency' => $this->currency,
            'amount' => $amount,
            'first_name' => Auth::user()->first_name,
            'last_name' => Auth::user()->last_name,
            'email' => Auth::user()->email,
            'phone' => Auth::user()->phone,
            'address' => Auth::user()->address,
            'city' => Auth::user()->city,
            'country' => Auth::user()->country,
            'hash' => $this->generateHash($paymentId, $amount),
        ];

        try {
            // Generate the HTML form for the payment
            $formHtml = $this->generatePaymentForm($payload);

            // Get the previous URL
            $previousUrl = url()->previous();

            // Store the form HTML in the session for redirect
            session()->flash('payment_form_html', $formHtml);

            // Return redirect URL with success response
            $response['redirect_url'] = $previousUrl;
            $response['payment_id'] = $paymentId;
            $response['success'] = true;
            $response['message'] = 'Redirecting to payment...';

        } catch (\Exception $e) {
            // Log error
            $response['message'] = $e->getMessage();
            Log::error('PayHere makePayment Error: ' . $e->getMessage());
        }

        return $response;
    }

    private function generateHash($orderId, $amount)
    {
        $hashValue = strtoupper(
            md5(
                $this->merchantId .
                $orderId .
                number_format($amount, 2, '.', '') .
                $this->currency .
                strtoupper(md5($this->merchantSecret))
            )
        );

        return $hashValue;
    }

    public function paymentConfirmation($paymentId)
    {
        // Initialize response structure
        $data = [
            'success' => false,
            'data' => null,
            'message' => __('Something went wrong during payment confirmation')
        ];

        // Get signature and encrypted data from the request
        $signature = request()->query('signature');
        $encryptedData = request()->query('data');

        try {
            // Decrypt the passed data
            $decryptedData = decrypt($encryptedData);
            list($userId, $timestamp) = explode('|', $decryptedData);

            // Verify the signature
            $expectedSignature = hash_hmac('sha256', $userId . '|' . $paymentId . '|' . $timestamp, $this->merchantSecret);

            if (hash_equals($expectedSignature, $signature)) {
                // If signature matches, confirm successful payment
                $data['success'] = true;
                $data['data']['payment_status'] = 'success';
                $data['data']['payment_method'] = PAYHERE;
            } else {
                $data['message'] = 'Signature mismatch';
            }

        } catch (\Exception $e) {
            $data['message'] = 'Invalid or tampered data';
            Log::error('PayHere Payment Verification Failed: ' . $e->getMessage());
        }

        return $data;
    }

    private function generatePaymentForm($payload)
    {
        // Generate HTML form for redirecting to PayHere
        $form = '<form method="post" action="' . $this->apiUrl . '">';
        foreach ($payload as $key => $value) {
            $form .= '<input type="hidden" name="' . $key . '" value="' . htmlspecialchars($value) . '">';
        }
        $form .= '<input type="submit" value="Pay Now">';
        $form .= '</form>';

        return $form;
    }
}
