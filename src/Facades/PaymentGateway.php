<?php

namespace Saeedeldeeb\PaymentGateway\Facades;

use Illuminate\Support\Facades\Facade;
use Saeedeldeeb\PaymentGateway\Contracts\PayableOrder;
use Saeedeldeeb\PaymentGateway\Contracts\PaymentGateway as PaymentGatewayInterface;

/**
 * @method static PaymentGatewayInterface gateway(string|null $name = null)
 * @method static PaymentGatewayInterface setOrder(PayableOrder $order)
 * @method static string getPaymentForm()
 * @method static string getPaymentResult($gatewayResponse = null)
 * @see \Saeedeldeeb\PaymentGateway\PaymentGateway
 */
class PaymentGateway extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Saeedeldeeb\PaymentGateway\PaymentGateway::class;
    }
}
