<?php


namespace App\Http\Services\Payment;

use Razorpay\Api\Api;

class RazorpayService
{
    protected $gatewayKeyId;
    protected $gatewayKeySecret;
    protected $api;
    private $successUrl;
    private $cancelUrl;
    private $currency;

    public function __construct($object)
    {

        if(isset($object['id'])){
            $this->cancelUrl = isset($object['cancelUrl']) ? $object['cancelUrl'] : route('paymentCancel', $object['id']);
            $this->successUrl = isset($object['successUrl']) ? $object['successUrl'] : route('paymentNotify', $object['id']);
        }

        // Fetch credentials using get_option
        $this->gatewayKeyId = get_option('razorpay_key');
        $this->gatewayKeySecret = get_option('razorpay_secret');

        // Set currency from the passed object, default to 'INR'
        $this->currency = $object['currency'] ?? 'INR';

        // Initialize Razorpay API with fetched credentials
        $this->api = new Api($this->gatewayKeyId, $this->gatewayKeySecret);
    }

    public function makePayment($amount, $post_data = null)
    {
        // Initialize response structure
        $data['success'] = false;
        $data['redirect_url'] = '';
        $data['payment_id'] = '';
        $data['message'] = __('Something went wrong');

        try {
            // Create payment link with the provided amount and details
            $payment = $this->api->paymentLink->create([
                'amount' => (int)($amount * 100), // Amount in paise (minor units)
                'currency' => $this->currency,
                'accept_partial' => true,
                'callback_url' => $this->successUrl,
                'callback_method' => 'get',
            ]);

            // Check if the payment creation was successful
            if ($payment->status == 'created') {
                $data['redirect_url'] = $payment->short_url;
                $data['payment_id'] = $payment->id;
                $data['success'] = true;
            }

            return $data;
        } catch (\Exception $ex) {
            // Log and return error message
            $data['message'] = $ex->getMessage();
            return $data;
        }
    }

    public function paymentConfirmation($payment_id, $payer_id = null)
    {
        // Initialize response structure
        $data['success'] = false;
        $data['data'] = null;

        try {
            // Fetch the payment link information
            $response = $this->api->paymentLink->fetch($payment_id);

            // Check if payment status is 'paid'
            if ($response['status'] == 'paid') {
                $data['success'] = true;
                $data['data']['amount'] = $response['amount'] / 100; // Convert from paise to base currency
                $data['data']['currency'] = $response['currency'];
                $data['data']['payment_status'] = 'success';
                $data['data']['payment_method'] = 'RAZORPAY';
            } else {
                $data['success'] = false;
                $data['data']['payment_status'] = 'unpaid';
                $data['data']['payment_method'] = 'RAZORPAY';
            }
        } catch (\Exception $ex) {
            // Log and return error message
            $data['message'] = $ex->getMessage();
        }

        return $data;
    }
}
