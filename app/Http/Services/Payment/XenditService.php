<?php

namespace App\Http\Services\Payment;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class XenditService
{
    private $paymentApiUrl = 'https://api.xendit.co/v2/invoices';
    private $transactionVerifyApiUrl = 'https://api.xendit.co/v2/invoices/';
    private $apiSecret;
    private $id;
    private $successUrl ;
    private $cancelUrl ;

    public $currency ;

    public function __construct($object)
    {
        if(isset($object['id'])){
            $this->cancelUrl = isset($object['cancelUrl ']) ? $object['cancelUrl '] : route('paymentCancel', $object['id']);
            $this->successUrl = isset($object['successUrl']) ? $object['successUrl'] : route('paymentNotify', $object['id']);
        }

        $this->apiSecret = get_option('xendit_key');
        $this->currency = $object['currency'];
    }

    public function makePayment($amount, $data = [])
    {
        $order_id = uniqid();
        $payload = array(
            "external_id" => $order_id,
            "amount" => $amount,
            "payer_email" => Auth::user()->email ?? 'email@example.com',
            "description" => "Payment for Order #{$order_id}",
            "currency" => $this->currency,
            "callback_url" => $this->successUrl,
            "success_redirect_url" => $this->successUrl, // URL to redirect after successful payment
            "failure_redirect_url" => $this->cancelUrl,
        );


        $response = $this->curl_request($payload, $this->paymentApiUrl);
        $data['success'] = false;
        $data['redirect_url'] = '';
        $data['payment_id'] = '';
        $data['message'] = 'Something went wrong';
        try {
            if (!empty($response->id)) {
                $data['redirect_url'] = $response->invoice_url;
                $data['payment_id'] = $response->id;
                $data['success'] = true;
            }else{
                $data['message'] = $response->message;
            }
            Log::info(json_encode($response));
            return $data;
        } catch (\Exception $ex) {
            $data['message'] = $ex->getMessage();
        }
        return $data;
    }

    public function paymentConfirmation($payment_id, $payerId= null)
    {
        $data['success'] = false;
        $data['data'] = null;
        $url = $this->transactionVerifyApiUrl . $payment_id;
        $payment = $this->curl_request([], $url, 'GET');
        if (!empty($payment->id) && $payment->status == 'PAID') {
            $data['success'] = true;
            $data['data']['amount'] = $payment->amount;
            $data['data']['currency'] = $this->currency;
            $data['data']['payment_status'] = 'success';
            $data['data']['payment_method'] = 'Xendit';
            // Store in your local database that the transaction was paid successfully
        } else {
            $data['success'] = false;
            $data['data']['amount'] = $payment->amount;
            $data['data']['currency'] = $this->currency;
            $data['data']['payment_status'] = 'unpaid';
            $data['data']['payment_method'] = 'Xendit';
        }

        return $data;
    }

    public function curl_request($payload, $url, $method = 'POST')
    {
        $fields_string = json_encode($payload);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
        } else {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Basic " . base64_encode($this->apiSecret . ":"),
            "Content-Type: application/json",
            "Cache-Control: no-cache",
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        return json_decode($result);
    }
}
