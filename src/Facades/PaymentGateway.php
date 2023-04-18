<?php

namespace Saeedeldeeb\PaymentGateway\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Saeedeldeeb\PaymentGateway\PaymentGateway
 */
class PaymentGateway extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Saeedeldeeb\PaymentGateway\PaymentGateway::class;
    }
}
