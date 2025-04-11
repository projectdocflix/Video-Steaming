<?php


namespace App\Http\Services\Payment;

use Illuminate\Support\Facades\Http;

class MarcadoPagoService
{
    private $gateway;
    private $successUrl;
    private $cancelUrl;
    private $currency;
    private $order_id;
    private $client_id;
    private $client_secret;
    private $test_mode;

    public function __construct($object)
    {
        if(isset($object['id'])){
           $this->cancelUrl = isset($object['cancelUrl ']) ? $object['cancelUrl '] : route('paymentCancel', $object['id']);
            $this->successUrl = isset($object['successUrl']) ? $object['successUrl'] : route('paymentNotify', $object['id']);
            $this->order_id = $object['id'];
        }

        $this->provider = $object['payment_method'];
        $this->currency = $object['currency'];

        $this->client_id = env('MERCADO_PAGO_CLIENT_ID');
        $this->client_secret = env('MERCADO_PAGO_CLIENT_SECRET');
        $this->test_mode = env('MERCADO_PAGO_TEST_MODE', true);
    }

    protected function getAccessToken()
    {
        $response = Http::asForm()->post('https://api.mercadopago.com/oauth/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
        ]);

        if ($response->successful()) {
            return $response->json('access_token');
        }

        throw new \Exception('Failed to fetch MercadoPago access token: ' . $response->body());
    }

    public function makePayment($price)
    {
        $data = ['success' => false, 'redirect_url' => '', 'payment_id' => '', 'message' => ''];

        try {
            $this->verifyCurrency();
            $accessToken = $this->getAccessToken();

            $paymentData = [
                'items' => [
                    [
                        'id' => $this->order_id,
                        'title' => 'Order #' . $this->order_id,
                        'quantity' => 1,
                        'unit_price' => (int)$price,
                        'currency_id' => $this->currency,
                    ],
                ],
                'back_urls' => [
                    'success' => $this->successUrl,
                    'failure' => $this->cancelUrl,
                    'pending' => $this->cancelUrl,
                ],
                'auto_return' => 'approved',
                'metadata' => [
                    'order_id' => $this->order_id,
                ],
            ];

            $response = Http::withToken($accessToken)
                ->post('https://api.mercadopago.com/checkout/preferences', $paymentData);

            if ($response->successful()) {
                $responseData = $response->json();
                $data['redirect_url'] = $responseData['init_point'] ?? '';
                $data['payment_id'] = $responseData['id'] ?? '';
                $data['success'] = true;
            } else {
                $data['message'] = $response->body();
            }

            return $data;
        } catch (\Exception $ex) {
            $data['message'] = $ex->getMessage();
            return $data;
        }
    }

    public function paymentConfirmation($payment_id)
    {
        $data = ['success' => false, 'data' => null];

        try {
            $accessToken = $this->getAccessToken();
            $response = Http::withToken($accessToken)
                ->get("https://api.mercadopago.com/v1/payments/{$payment_id}");

            if ($response->successful()) {
                $payment = $response->json();

                if (!empty($payment) && $payment['status'] === 'approved') {
                    $data['success'] = true;
                    $data['data'] = [
                        'amount' => $payment['transaction_amount'],
                        'currency' => $this->currency,
                        'payment_status' => 'success',
                        'payment_method' => 'MERCADOPAGO',
                    ];
                } else {
                    $data['data'] = [
                        'currency' => $this->currency,
                        'payment_status' => 'unpaid',
                        'payment_method' => 'MERCADOPAGO',
                    ];
                }
            } else {
                throw new \Exception('Failed to retrieve payment details: ' . $response->body());
            }

            return $data;
        } catch (\Exception $ex) {
            $data['data']['error'] = $ex->getMessage();
            return $data;
        }
    }

    private function verifyCurrency()
    {
        if (!in_array($this->currency, $this->supportedCurrencyList(), true)) {
            throw new \Exception($this->currency . ' is not supported by ' . $this->gatewayName());
        }
    }

    private function supportedCurrencyList()
    {
        return ['BRL', 'ARS', 'MXN', 'USD', 'COP', 'CLP', 'UYU', 'PEN', 'VEF', 'PYG'];
    }

    private function gatewayName()
    {
        return 'MercadoPago';
    }
}
