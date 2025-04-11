<?php

namespace App\Http\Services\Payment;

use Illuminate\Support\Facades\Log;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class AuthorizeNetService
{
    public $merchantAuthentication;
    public $environment;
    public $baseUrl;
    public $successUrl;
    public $cancelUrl;
    public $currency;

    public function __construct($object)
    {
        // Retrieve API credentials dynamically using get_option()
        $apiLoginId = get_option('authorize_key');
        $transactionKey = get_option('authorize_secret');

        // Set up the Merchant Authentication for Authorize.Net
        $this->merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $this->merchantAuthentication->setName($apiLoginId); // API Login ID
        $this->merchantAuthentication->setTransactionKey($transactionKey); // Transaction Key
        $this->currency = isset($object['currency']) ? $object['currency'] : 'USD';  // Set default currency as XOF (CFA Franc)
        // Determine the environment based on the mode (sandbox or live)
        $gatewayMode = get_option('authorize_net_mode'); // Fetch the mode from options

        if ($gatewayMode == 'sandbox') {
            $this->environment = \net\authorize\api\constants\ANetEnvironment::SANDBOX;
            $this->baseUrl = 'https://test.authorize.net/payment/payment-form?token=';
        } else {
            $this->environment = \net\authorize\api\constants\ANetEnvironment::PRODUCTION;
            $this->baseUrl = 'https://accept.authorize.net/payment/payment-form?token=';
        }

        // Set success and cancel URLs, defaulting to routes if not provided
        if (isset($object['id'])) {
            $this->successUrl = isset($object['successUrl']) ? $object['successUrl'] : route('paymentNotify', $object['id']);
            $this->cancelUrl = isset($object['cancelUrl']) ? $object['cancelUrl'] : route('paymentCancel', $object['id']);
        }
    }

    public function makePayment($amount, $post_data = null)
    {
        try {
            $token = $this->getHostedPaymentPageToken($amount, $this->successUrl);

            $data['success'] = true;
            $data['redirect_url'] = $this->baseUrl . $token;
            $data['payment_id'] = $token;

            Log::info('Authorize.Net Hosted Payment Token: ' . json_encode($data));
            return $data;
        } catch (\Exception $ex) {
            Log::error('Authorize.Net Error: ' . $ex->getMessage());
            $data['success'] = false;
            $data['message'] = $ex->getMessage();
            return $data;
        }
    }

    private function getHostedPaymentPageToken($amount, $returnUrl)
    {
        $refId = 'ref' . time();

        // Create a transaction request object
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($amount);

        // Setting options for hosted payment
        $setting1 = new AnetAPI\SettingType();
        $setting1->setSettingName("hostedPaymentButtonOptions");
        $setting1->setSettingValue(json_encode(["text" => "Pay Now"]));

        $setting2 = new AnetAPI\SettingType();
        $setting2->setSettingName("hostedPaymentReturnOptions");
        $setting2->setSettingValue(json_encode(["url" => $returnUrl, "showReceipt" => true]));

        // Create the request object
        $request = new AnetAPI\GetHostedPaymentPageRequest();
        $request->setMerchantAuthentication($this->merchantAuthentication);
        $request->setTransactionRequest($transactionRequestType);
        $request->addToHostedPaymentSettings($setting1);
        $request->addToHostedPaymentSettings($setting2);

        // Execute request
        $controller = new AnetController\GetHostedPaymentPageController($request);
        $response = $controller->executeWithApiResponse($this->environment);

        // Check response
        if ($response != null && $response->getMessages()->getResultCode() == "Ok") {
            return $response->getToken();
        } else {
            $errorMessages = $response->getMessages()->getMessage();
            throw new \Exception("Error: " . $errorMessages[0]->getText());
        }
    }

    public function paymentConfirmation($payment_id)
    {
        $data['data'] = null;
        Log::info("------Authorize.Net Payment Confirmation----");
        Log::info($payment_id);

        try {
            // Create transaction details request
            $request = new AnetAPI\GetTransactionDetailsRequest();
            $request->setMerchantAuthentication($this->merchantAuthentication);
            $request->setTransId($payment_id);

            // Execute the request
            $controller = new AnetController\GetTransactionDetailsController($request);
            $response = $controller->executeWithApiResponse($this->environment);

            Log::info(json_encode($response));

            if ($response != null && $response->getMessages()->getResultCode() == "Ok") {
                $transaction = $response->getTransaction();
                $data['success'] = $transaction->getTransactionStatus() == 'settledSuccessfully';
                $data['data']['amount'] = $transaction->getAuthAmount();
                $data['data']['currency'] = $transaction->getCurrencyCode();
                $data['data']['payment_status'] = $data['success'] ? 'success' : 'unpaid';
                $data['data']['payment_method'] = 'Authorize.Net';
            } else {
                $data['success'] = false;
                $data['message'] = "Failed to retrieve transaction details.";
                if ($response != null) {
                    $errorMessages = $response->getMessages()->getMessage();
                    if (!empty($errorMessages)) {
                        $data['message'] = $errorMessages[0]->getText();
                    }
                }
            }
        } catch (\Exception $ex) {
            Log::error('Authorize.Net Payment Confirmation Error: ' . $ex->getMessage());
            $data['success'] = false;
            $data['message'] = $ex->getMessage();
        }

        return $data;
    }
}
