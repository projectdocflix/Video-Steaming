<?php

namespace App\Http\Services\Payment;

use paytm\paytmchecksum\PaytmChecksum;
use Illuminate\Support\Facades\Log;

class PaytmService
{
    private $url;
    private $merchantId;
    private $merchantKey;
    private $merchantWebsite;
    private $industryType;
    private $channel;
    private $orderId;
    public $currency;
    private $successUrl;
    private $cancelUrl;

    public function __construct($object)
    {

        // Set callback URLs
        $this->cancelUrl = isset($object['cancelUrl']) ? $object['cancelUrl'] : route('paymentCancel', $object['id']);
        $this->successUrl = isset($object['successUrl']) ? $object['successUrl'] : route('paymentNotify', $object['id']);

        // Fetch merchant credentials from the passed object or gateway
        $this->merchantId = get_option('paytm_secret');  // Merchant ID comes from the key
        $this->merchantKey = get_option('paytm_key');  // Merchant secret comes from the secret field
        $this->industryType = get_option('paytm_url');  // Industry type or other relevant config may come from the URL field

        // Additional required configurations
        $this->merchantWebsite = get_option('paytm_mode') === 'live' ? 'DEFAULT' : 'WEBSTAGING';
        $this->channel = 'WEB';

        // Set currency from the passed object, default to 'INR'
        $this->currency = $object['currency'] ?? 'INR';

        $this->orderId = uniqid();

        // Set the appropriate Paytm URL based on the mode (live or staging)
        $this->url = get_option('paytm_mode') === 'live'
            ? "https://securegw.paytm.in"  // Live URL
            : "https://securegw-stage.paytm.in";  // Staging URL
    }

    /**
     * Initiate a Paytm payment
     * @param $amount
     * @param null $post_data
     * @return array
     */
    public function makePayment($amount, $post_data = null)
    {
        // Initialize response structure
        $response = [
            'success' => false,
            'redirect_url' => '',
            'payment_id' => '',
            'message' => __('Something went wrong')
        ];

        $paytmParams = array();

        // Body parameters for the request
        $paytmParams["body"] = array(
            "requestType"   => "Payment",
            "mid"           => $this->merchantId,
            "websiteName"   => $this->merchantWebsite,
            "orderId"       => $this->orderId,
            "callbackUrl"   => $this->successUrl,
            "txnAmount"     => array(
                "value"     => $amount,
                "currency"  => $this->currency
            ),
            "userInfo"      => array(
                "custId"    => uniqid()  // Random unique customer ID
            ),
        );

        // Generate checksum
        $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $this->merchantKey);

        // Head parameters containing the generated signature
        $paytmParams["head"] = array(
            "signature"    => $checksum
        );

        // Convert params to JSON format for the cURL request
        $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

        $orderUrl = $this->url."/theia/api/v1/initiateTransaction?mid={$this->merchantId}&orderId={$this->orderId}";
        // cURL request to Paytm
        $ch = curl_init($orderUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        $responsePaytm = curl_exec($ch);

        // Handle errors
        if (curl_errno($ch)) {
            $error_message = curl_error($ch);
            curl_close($ch);
            Log::error('Paytm makePayment Error: ' . $error_message);
            return [
                'success' => false,
                'message' => $error_message
            ];
        }

        curl_close($ch);

        $result = json_decode($responsePaytm, true);

        // Check if the response contains a success status
        if (isset($result['body']['resultInfo']['resultStatus']) && $result['body']['resultInfo']['resultStatus'] == 'S') {
            // Create the form using the txnToken received from Paytm
            $txnToken = $result['body']['txnToken'];
            $formHtml = $this->generatePaytmPaymentForm($txnToken);

            // Store the form in session so the view can auto-submit
            session()->flash('payment_form_html', $formHtml);

            // Get the previous URL
            $previousUrl = url()->previous();

            $response['redirect_url'] = $previousUrl;
            $response['payment_id'] = $this->orderId;
            $response['success'] = true;
            $response['message'] = 'Redirecting to payment...';

            return $response;
        } else {
            Log::error('Paytm Payment initiation failed: ' . json_encode($result));
            return [
                'success' => false,
                'message' => 'Payment initiation failed',
            ];
        }
    }

    private function generatePaytmPaymentForm($txnToken)
    {
        $mid = $this->merchantId;
        $orderId = $this->orderId;

        // Build the HTML form
        $form = <<<HTML
    <form method="post" action="{$this->url}/theia/api/v1/showPaymentPage?mid={$mid}&orderId={$orderId}" name="paytm">
         <input type="hidden" name="mid" value="{$mid}">
         <input type="hidden" name="orderId" value="{$orderId}">
         <input type="hidden" name="txnToken" value="{$txnToken}">
    </form>
HTML;

        return $form;
    }

    /**
     * Validate the Paytm payment confirmation from callback
     * @param string $orderId
     * @return array
     */
    public function paymentConfirmation($orderId, $payerId=null)
    {
        $paytmParams = array();

        // Body parameters
        $paytmParams["body"] = array(
            "mid" => $this->merchantId,
            "orderId" => $orderId,
        );

        // Generate checksum
        $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $this->merchantKey);

        // Head parameters containing the generated checksum
        $paytmParams["head"] = array(
            "signature" => $checksum
        );

        // Convert the request data to JSON format
        $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

        // cURL request to Paytm to check the payment status
        $ch = curl_init($this->url."/v3/order/status");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $responsePaytm = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_message = curl_error($ch);
            curl_close($ch);
            Log::error('Paytm Payment Confirmation Error: ' . $error_message);
            return [
                'success' => false,
                'message' => $error_message
            ];
        }

        curl_close($ch);

        // Decode the response from Paytm
        $result = json_decode($responsePaytm, true);

        $data['success'] = false;
        $data['data'] = null;

        // Check if the result contains a valid status
        if (isset($result['body']['resultInfo']['resultStatus']) && $result['body']['resultInfo']['resultStatus'] == 'TXN_SUCCESS') {
            $data['success'] = true;
            $data['data'] = [
                'payment_status' => 'success',
                'payment_method' => 'PAYTM'
            ];
        } else {
            $data['message'] = 'Payment not approved';
        }

        return $data;
    }
}
