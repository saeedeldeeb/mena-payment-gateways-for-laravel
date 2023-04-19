<?php

namespace Saeedeldeeb\PaymentGateway\Contracts;

use Saeedeldeeb\PaymentGateway\PaymentTransaction;

interface PaymentGateway
{
    public function frameData(PaymentTransaction $paymentTransaction): array;

    public function response(array $responseData);
}
