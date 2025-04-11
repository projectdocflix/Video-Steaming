<?php

namespace App\Http\Services\Payment;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ToyyibPayService
{
    private $toyyibUrl;
    private $userSecretKey;
    private $categoryCode;
    private $orderId;
    private $successUrl;
    private $cancelUrl;

    private $currency;

    public function __construct($object)
    {
        // Retrieve settings dynamically from your configuration (get_option or similar)
        $this->toyyibUrl = get_option('toyyibpay_mode') === 'live' ? 'https://toyyibpay.com' : 'https://dev.toyyibpay.com';
        $this->userSecretKey = get_option('toyyibpay_key');
        $this->categoryCode = get_option('toyyibpay_secret');
        // Set currency from the passed object, default to 'INR'
        $this->currency = $object['currency'] ?? 'INR';

        if(isset($object['id'])){
            $this->cancelUrl = isset($object['cancelUrl']) ? $object['cancelUrl'] : route('paymentCancel', $object['id']);
            $this->successUrl = isset($object['successUrl']) ? $object['successUrl'] : route('paymentNotify', $object['id']);
        }

        // Set the order ID if available
        $this->orderId = isset($object['id']) ? $object['id'] : null;

    }

    public function makePayment($amount, $postData = [])
    {
        // Generate a unique transaction ID
        $transaction_id = sha1($this->orderId);

        // Prepare payload for creating the bill
        $payload = [
            'userSecretKey' => $this->userSecretKey,
            'categoryCode' => $this->categoryCode,
            'billName' => 'Product Purchase',
            'billDescription' => 'Description of the product',
            'billAmount' => $amount * 100, // Convert amount to cents
            'billReturnUrl' => $this->successUrl,
            'billCallbackUrl' => $this->successUrl,
            'billExternalReferenceNo' => $transaction_id,
            'billTo' => Auth::user()->name ?? 'User',
            'billEmail' => Auth::user()->email,
            'billPhone' => Auth::user()->mobile ?? '000000',
            'billPaymentChannel' => 0, // Allow all payment channels
            'billChargeToCustomer' => 1, // Charge customer
            'billPriceSetting' => 1, // Fixed price
            'billPayorInfo' => 0 // Don't require additional payor info
        ];

        // Initialize response structure
        $data = [
            'success' => false,
            'redirect_url' => '',
            'payment_id' => '',
            'message' => __('Something went wrong')
        ];

        try {
            // Create the bill via ToyyibPay API
            $response = Http::asForm()->post("{$this->toyyibUrl}/index.php/api/createBill", $payload);

            if ($response->successful()) {
                $responseData = json_decode($response->body(), true);

                // Check if BillCode is present in the response
                if (isset($responseData[0]['BillCode'])) {
                    $billCode = $responseData[0]['BillCode'];

                    // Set successful payment data
                    $data['success'] = true;
                    $data['redirect_url'] = "{$this->toyyibUrl}/{$billCode}";
                    $data['payment_id'] = $billCode;
                } else {
                    // Set error message if BillCode is missing
                    $data['message'] = __('Failed to create payment bill.');
                }
            } else {
                // Set error message if API response is not successful
                $data['message'] = __('Failed to create payment bill.');
            }
        } catch (\Exception $e) {
            // Catch any exceptions and set error details
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    public function paymentConfirmation($payment_id, $payerId= null)
    {
        // Initialize response structure
        $data = [
            'success' => false,
            'message' => __('Payment verification failed'),
        ];

        // Prepare the payload for checking the transaction status
        $payload = [
            'userSecretKey' => $this->userSecretKey,
            'billCode' => $payment_id, // BillCode used to retrieve the transaction status
        ];

        try {
            // Get the bill transactions via ToyyibPay API
            $response = Http::asForm()->post("{$this->toyyibUrl}/index.php/api/getBillTransactions", $payload);

            // Check if the API response is successful
            if ($response->successful()) {
                $responseData = json_decode($response->body(), true);

                // Check for valid bill payment status
                if (isset($responseData[0]['billpaymentStatus'])) {
                    $paymentStatus = $responseData[0]['billpaymentStatus'];

                    // Check if payment was successful (status == 1)
                    if ($paymentStatus == 1) {
                        $data['success'] = true;
                        $data['message'] = __('Payment approved');
                        $data['data'] = [
                            'amount' => $responseData[0]['billpaymentAmount'] / 100, // Amount is in cents, convert to base units
                            'currency' => 'MYR', // Assuming the currency is MYR
                            'payment_status' => 'success',
                            'payment_method' => 'ToyyibPay',
                            'payment_date' => $responseData[0]['billPaymentDate'],
                            'transaction_reference' => $responseData[0]['billExternalReferenceNo'],
                            'invoice_no' => $responseData[0]['billpaymentInvoiceNo'],
                            'settlement_status' => $responseData[0]['billpaymentSettlement'], // e.g., Pending Settlement
                        ];
                    } else {
                        // Set response for failed payment
                        $data['data'] = [
                            'payment_status' => 'failed',
                            'transaction_reference' => $responseData[0]['billExternalReferenceNo'],
                        ];
                    }
                } else {
                    // Set response for invalid payment status
                    $data['message'] = __('No transaction found for the provided BillCode.');
                }
            } else {
                // Set response for failed API request
                $data['message'] = __('Failed to retrieve transaction details.');
            }
        } catch (\Exception $e) {
            // Catch any exceptions and set error details
            $data['message'] = $e->getMessage();
        }

        return $data;
    }
}
