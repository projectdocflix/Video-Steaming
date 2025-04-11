<?php

namespace App\Http\Services\Payment;

class AlipayService
{
    protected $gatewayUrl = 'https://open-na-global.alipay.com';
    protected $appId;
    protected $privateKey;
    protected $alipayPublicKey;
    protected $signType = 'RSA2';
    protected $successUrl;
    protected $cancelUrl;
    protected $currency;

    public function __construct($object)
    {
        // Retrieve the credentials and keys dynamically from configuration
        $this->appId = get_option('alipay_url');  // Alipay app ID
        $this->privateKey = get_option('alipay_secret');  // Private key for signing requests
        $this->alipayPublicKey = get_option('alipay_key');  // Alipay's public key
        $this->currency = isset($object['currency']) ? $object['currency'] : 'USD';  // Set default currency as XOF (CFA Franc)

        // Set success and cancel URLs
        if (isset($object['id'])) {
            $this->successUrl = isset($object['successUrl']) ? $object['successUrl'] : route('paymentNotify', $object['id']);
            $this->cancelUrl = isset($object['cancelUrl']) ? $object['cancelUrl'] : route('paymentCancel', $object['id']);
        }
    }

    public function makePayment($amount, $postData = [])
    {
        $data = [
            'success' => false,
            'redirect_url' => '',
            'payment_id' => '',
            'message' => __('Something went wrong'),
        ];

        try {
            $sale_id = uniqid();
            $description = 'Payment for order';

            // Generate the Alipay payment URL
            $paymentUrl = $this->createPayment($sale_id, $amount, $this->currency, $description, $this->successUrl, $this->cancelUrl);

            if ($paymentUrl) {
                $data['payment_id'] = $sale_id;
                $data['success'] = true;
                $data['redirect_url'] = $paymentUrl;
            }

            return $data;
        } catch (\Exception $ex) {
            $data['message'] = $ex->getMessage();
            return $data;
        }
    }

    public function paymentConfirmation($payment_id, $payerId = null)
    {
        $data = ['data' => null];

        try {
            $paymentData = $_POST;  // Assuming Alipay sends POST data for confirmation
            $isVerified = $this->verifyPayment($paymentData);

            if ($isVerified && $paymentData['out_trade_no'] === $payment_id) {
                $data['success'] = true;
                $data['data'] = [
                    'amount' => $paymentData['total_amount'],
                    'currency' => $this->currency,
                    'payment_status' => 'success',
                    'payment_method' => 'ALIPAY',
                ];
            } else {
                $data['success'] = false;
                $data['data'] = [
                    'amount' => $paymentData['total_amount'],
                    'currency' => $this->currency,
                    'payment_status' => 'unpaid',
                    'payment_method' => 'ALIPAY',
                ];
            }

            return $data;
        } catch (\Exception $ex) {
            $data['message'] = $ex->getMessage();
            return $data;
        }
    }

    protected function createPayment($sale_id, $amount, $currency, $description, $return_url, $notify_url)
    {
        $params = [
            'app_id' => $this->appId,
            'method' => 'alipay.trade.page.pay',
            'format' => 'JSON',
            'return_url' => $return_url,
            'notify_url' => $notify_url,
            'charset' => 'UTF-8',
            'sign_type' => $this->signType,
            'timestamp' => date('Y-m-d H:i:s'),
            'version' => '1.0',
            'biz_content' => json_encode([
                'out_trade_no' => $sale_id,
                'product_code' => 'FAST_INSTANT_TRADE_PAY',
                'total_amount' => $amount,
                'subject' => $description,
            ]),
        ];

        // Generate the sign for the request
        $params['sign'] = $this->generateSign($params);

        // Build the query string for the URL
        $query = http_build_query($params);
        return $this->gatewayUrl . '?' . $query;
    }

    protected function verifyPayment($paymentData)
    {
        $sign = $paymentData['sign'];
        unset($paymentData['sign']);
        unset($paymentData['sign_type']);

        $content = urldecode(http_build_query($paymentData));
        $publicKey = "-----BEGIN PUBLIC KEY-----\n" . wordwrap($this->alipayPublicKey, 64, "\n", true) . "\n-----END PUBLIC KEY-----";

        return openssl_verify($content, base64_decode($sign), $publicKey, OPENSSL_ALGO_SHA256) === 1;
    }

    protected function generateSign($params)
    {
        ksort($params);
        $stringToSign = urldecode(http_build_query($params));
        $privateKey = "-----BEGIN PRIVATE KEY-----\n" . wordwrap($this->privateKey, 64, "\n", true) . "\n-----END PRIVATE KEY-----";

        openssl_sign($stringToSign, $sign, $privateKey, OPENSSL_ALGO_SHA256);
        return base64_encode($sign);
    }
}
