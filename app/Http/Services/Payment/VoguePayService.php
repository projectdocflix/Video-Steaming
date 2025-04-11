<?php

namespace App\Http\Services\Payment;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class VoguePayService
{
    private $merchantId;
    private $apiUrl;
    private $orderId;
    private $successUrl;
    private $cancelUrl;

    private $currency;

    public function __construct($object)
    {
        // Fetch merchant ID dynamically
        $this->merchantId = get_option('voguepay_key');  // VoguePay's Merchant ID
        $this->apiUrl = 'https://voguepay.com/pay/';  // VoguePay API URL
        // Set currency from the passed object, default to 'INR'
        $this->currency = $object['currency'] ?? 'INR';

        // Set the order ID if available
        if (isset($object['id'])) {
            $this->orderId = $object['id'];

            // If custom cancelUrl and successUrl are provided in the object, use them
            $this->cancelUrl = isset($object['cancelUrl']) ? $object['cancelUrl'] : route('paymentCancel', $object['id']);
            $this->successUrl = isset($object['successUrl']) ? $object['successUrl'] : route('paymentNotify', $object['id']);
        }
    }

    public function makePayment($amount, $postData = [])
    {
        // Generate a unique transaction ID
        $transaction_id = sha1($this->orderId);

        // Prepare the payload for VoguePay
        $payload = [
            'v_merchant_id' => $this->merchantId,
            'merchant_ref' => $transaction_id,  // Unique transaction ID
            'memo' => 'Payment for purchase',  // Memo or description of the payment
            'total' => $amount,  // Payment amount
            'cur' => 'NGN',  // Currency (can be dynamic, here it's NGN)
            'success_url' => $this->successUrl,  // Success URL after payment
            'fail_url' => $this->cancelUrl,  // Failure URL if payment is canceled or fails
            'notify_url' => $this->successUrl,  // Notification URL for payment status updates (webhook)
            'buyer_email' => Auth::user()->email,  // Buyer's email
            'buyer_name' => Auth::user()->name,  // Buyer's name
        ];

        // Log the payload for debugging purposes
        Log::info('<<<< VoguePay Request Payload >>>>');
        Log::info(json_encode($payload));

        // Prepare the response structure
        $data = [
            'success' => true,
            'redirect_url' => $this->apiUrl . '?' . http_build_query($payload),  // VoguePay redirect URL
            'payment_id' => $transaction_id,  // Transaction ID
        ];

        return $data;
    }

    public function paymentConfirmation($payment_id)
    {
        // Initialize response structure
        $data = [
            'success' => false,
            'data' => null,
        ];

        // VoguePay transaction verification URL
        $verificationUrl = "https://voguepay.com/?v_transaction_id=" . $payment_id . "&type=json";

        try {
            // Make the request to VoguePay to verify the payment status
            $response = Http::get($verificationUrl);

            if ($response->successful()) {
                $responseData = $response->json();

                // Check if the payment status is approved
                if (isset($responseData['status']) && $responseData['status'] == 'Approved') {
                    $data['success'] = true;
                    $data['data'] = [
                        'amount' => $responseData['total_paid_by_buyer'],  // Payment amount
                        'currency' => 'NGN',
                        'payment_status' => 'success',
                        'payment_method' => VOGUEPAY,
                        'payment_date' => $responseData['date'],
                    ];
                } else {
                    // Set the error message if the payment was not approved
                    $data['message'] = $responseData['status_description'] ?? 'Payment not approved';
                }
            } else {
                $data['message'] = 'Failed to retrieve payment details.';
            }
        } catch (\Exception $e) {
            // Handle any errors and set the error message
            $data['message'] = $e->getMessage();
        }

        return $data;
    }
}
