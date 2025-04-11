<?php

namespace App\Http\Services\Payment;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PaddleService extends BasePaymentService
{
    private $successUrl;
    private $cancelUrl;
    private $provider;
    private $currency;
    public $orderId;
    public $payment_id;
    public $baseUrl;

    public function __construct($object)
    {
        if (isset($object['id'])) {
            $this->cancelUrl = isset($object['cancelUrl']) ? $object['cancelUrl'] : route('paymentCancel', $object['id']);
            $this->successUrl = isset($object['successUrl']) ? $object['successUrl'] : route('paymentNotify', $object['id']);
            $this->orderId = $object['id'];
        }

        $this->provider = $object['payment_method'];
        $this->currency = $object['currency'];
    }

    public function makePayment($amount, $bodyData = [])
    {
        $this->payment_id = sha1($this->orderId);
        $data = [
            'success' => false,
            'redirect_url' => '',
            'payment_id' => '',
            'message' => 'SOMETHING_WENT_WRONG',
        ];

        try {
            $response = $this->generatePayLink($amount);
            Log::info(json_encode($response));

            if ($response['success']) {
                $data['payment_id'] = $this->payment_id;
                $data['success'] = true;
                $data['redirect_url'] = $response['response']['url'];
            }

            return $data;
        } catch (\Exception $ex) {
            Log::error('Payment generation failed: ' . $ex->getMessage());
            $data['message'] = $ex->getMessage();
        }

        return $data;
    }

    public function paymentConfirmation($payment_id, $payerId = null)
    {
        $data = ['data' => null];
        Log::info("------payment confirmation----");
        Log::info($payment_id);

        // Here we use Paddle's API or webhook response to confirm payment
        $payment = $this->retrievePaddlePayment($payment_id);
        Log::info(json_encode($payment));

        if (isset($payment['payment_status']) && $payment['payment_status'] == 'paid') {
            $data['success'] = true;
            $data['data'] = [
                'amount' => $payment['amount'],
                'currency' => $payment['currency'],
                'payment_status' => 'success',
                'payment_method' => 'paddle',
            ];
        } else {
            $data['success'] = false;
            $data['data'] = [
                'amount' => $payment['amount'],
                'currency' => $payment['currency'],
                'payment_status' => 'unpaid',
                'payment_method' => 'paddle',
            ];
        }

        return $data;
    }

    public function generatePayLink($price)
    {
        $this->baseUrl = (get_option('paddle_mode') === 'sandbox') ?
            'https://sandbox-api.paddle.com/api/2.0/' :
            'https://vendors.paddle.com/api/2.0/';

        $options = [
            'vendor_id' => get_option('paddle_url'),
            'vendor_auth_code' => get_option('paddle_key'),
            'title' => 'Order #' . $this->orderId,
            'prices' => ['USD:' . $price], // You can change the currency as needed
            'return_url' => $this->successUrl, // Success URL for successful payment
            'cancel_url' => $this->cancelUrl,  // Use the cancel URL in your payment request
            'customer_email' => Auth::user()->email ?? 'example@gmail.com', // Handle non-authenticated users
            'webhook_url' => $this->successUrl, // Set your webhook URL to receive payment updates
        ];

        $response = Http::asForm()->post($this->baseUrl . 'product/generate_pay_link', $options);

        if ($response->failed()) {
            Log::error('Paddle API request failed: ' . $response->body());
            throw new \Exception('Failed to generate payment link');
        }

        return $response->json();
    }

    private function retrievePaddlePayment($payment_id)
    {
        // Paddle's webhook will give you a payment ID and payment status after a successful payment.
        // To retrieve payment details, you'll need to implement the webhook on your server
        // or use the Paddle API to get transaction details.

        // Assuming we have received a webhook or another API call:
        $response = Http::post($this->baseUrl . 'payment/status', [
            'payment_id' => $payment_id,
            'vendor_id' => get_option('paddle_url'),
            'vendor_auth_code' => get_option('paddle_key')
        ]);

        if ($response->failed()) {
            Log::error('Paddle Payment retrieval failed: ' . $response->body());
            throw new \Exception('Failed to retrieve payment status');
        }

        return $response->json();
    }
}
