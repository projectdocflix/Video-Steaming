<?php


namespace App\Http\Services\Payment;

use Illuminate\Support\Facades\Log;

class BasePaymentService
{
    public  $get_way = null;
    private $provider = null;
    public function __construct($object)
    {
        $this->provider = $object['payment_method'];

        $classPath = getPaymentServiceClass($this->provider);
        $this->get_way = new $classPath($object);
    }

    public function makePayment($amount,$post_data=null){
        $res = $this->get_way->makePayment($amount,$post_data);
        Log::info($res);
        return $res;
    }

    public function paymentConfirmation($payment_id,$payer_id=null){
        if(is_null($payer_id)){
            return $this->get_way->paymentConfirmation($payment_id);
        }
        return $this->get_way->paymentConfirmation($payment_id,$payer_id);
    }


}
