<?php

namespace App\Http\Services\Payment;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class BinancePaymentService
{
    protected $binanceApi;
    protected $binanceSecret;
    protected $url;
    protected $successUrl;
    protected $cancelUrl;
   protected $currency;

    public function __construct($object)
    {
        // Retrieve the API and Secret from your configuration dynamically
        $this->binanceApi = get_option('binance_key'); // Assuming key stores the Binance API key
        $this->binanceSecret = get_option('binance_secret'); // Assuming secret stores the Binance secret

        $this->currency = isset($object['currency']) ? $object['currency'] : 'USD';  // Set default currency as XOF (CFA Franc)
        $this->url = 'https://bpay.binanceapi.com/binancepay/openapi/v3/order';

        // Set successUrl and cancelUrl from the object, or use default routes
        if (isset($object['id'])) {
            $this->successUrl = isset($object['successUrl']) ? $object['successUrl'] : route('paymentNotify', $object['id']);
            $this->cancelUrl = isset($object['cancelUrl']) ? $object['cancelUrl'] : route('paymentCancel', $object['id']);
        }
    }

    public function makePayment($amount, $post_data = null)
    {
        $nonce = $this->generateNonce();
        $timestamp = round(microtime(true) * 1000);
        $uniqid = uniqid() . rand(10000, 99999);

        $data = [
            "env" => [
                "terminalType" => "WEB"
            ],
            "merchantTradeNo" => $uniqid,
            "orderAmount" => $amount, // You may want to ensure the amount is in the correct unit
            "currency" => 'USDT', // You can change this to $this->currency if it’s dynamic
            "description" => "Payment for order " . $uniqid,
            "goodsDetails" => [
                [
                    "goodsType" => "01",
                    "goodsCategory" => "D000",
                    "referenceGoodsId" => $uniqid,
                    "goodsName" => "Product Name",
                    "goodsDetail" => "Product description here"
                ]
            ],
            "returnUrl" => $this->successUrl, // Use success URL here
            "cancelUrl" => $this->cancelUrl // Use cancel URL here
        ];

        $jsonRequest = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $payload = $timestamp . "\n" . $nonce . "\n" . $jsonRequest . "\n";
        $signature = strtoupper(hash_hmac('SHA512', $payload, $this->binanceSecret));

        $response = Http::withHeaders([
            "Content-Type" => "application/json",
            "BinancePay-Timestamp" => $timestamp,
            "BinancePay-Nonce" => $nonce,
            "BinancePay-Certificate-SN" => $this->binanceApi,
            "BinancePay-Signature" => $signature,
        ])->withBody($jsonRequest, 'application/json')  // Sending JSON request as the body
        ->post($this->url)
            ->json();

        Log::info('Binance Payment Response:', $response);

        $data['success'] = false;
        $data['redirect_url'] = '';
        $data['payment_id'] = '';
        $data['message'] = __('Something went wrong');

        if (isset($response['status']) && $response['status'] == "SUCCESS") {
            $data['success'] = true;
            $data['redirect_url'] = $response['data']['checkoutUrl'] ?? '';
            $data['payment_id'] = $uniqid;
        } else {
            $data['message'] = $response['errorMessage'] ?? __('Something went wrong during payment');
        }

        return $data;
    }

    public function paymentConfirmation($payment_id, $payer_id = null)
    {
        $data['success'] = false;
        $data['data'] = null;

        // Prepare the payload to query Binance for payment status
        $queryPayload = [
            "merchantTradeNo" => $payment_id
        ];

        $timestamp = round(microtime(true) * 1000);
        $nonce = $this->generateNonce();

        $jsonRequest = json_encode($queryPayload);
        $payloadToSign = $timestamp . "\n" . $nonce . "\n" . $jsonRequest . "\n";
        $querySignature = strtoupper(hash_hmac('SHA512', $payloadToSign, $this->binanceSecret));

        $response = Http::withHeaders([
            "Content-Type" => "application/json",
            "BinancePay-Timestamp" => $timestamp,
            "BinancePay-Nonce" => $nonce,
            "BinancePay-Certificate-SN" => $this->binanceApi,
            "BinancePay-Signature" => $querySignature,
        ])->withBody($jsonRequest, 'application/json')  // Sending JSON request as the body
        ->post('https://bpay.binanceapi.com/binancepay/openapi/v2/order/query')
            ->json();

        if (isset($response['status']) && $response['status'] == "SUCCESS" && $response['data']['status'] == "PAID") {
            $data['success'] = true;
            $data['data'] = [
                'payment_status' => 'success',
                'payment_method' => 'BINANCE',
                'amount' => $response['data']['totalFee'],
                'currency' => $response['data']['currency'],
                'transaction_id' => $response['data']['transactionId'],
                'merchant_trade_no' => $response['data']['merchantTradeNo'],
            ];
        } else {
            $data['message'] = $response['errorMessage'] ?? 'Payment verification failed';
        }

        return $data;
    }

    protected function generateNonce()
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $nonce = '';
        for ($i = 1; $i <= 32; $i++) {
            $pos = mt_rand(0, strlen($chars) - 1);
            $nonce .= $chars[$pos];
        }
        return $nonce;
    }
}
