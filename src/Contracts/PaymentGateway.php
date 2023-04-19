<?php

namespace Saeedeldeeb\PaymentGateway\Contracts;

use Saeedeldeeb\PaymentGateway\PaymentTransaction;

interface PaymentGateway
{
    const PAYMENT_RESULT_COMPLETED = 'completed';
    const PAYMENT_RESULT_DECLINED = 'declined';
    const PAYMENT_RESULT_CANCELED = 'canceled';
    const PAYMENT_RESULT_FAILED = 'failed';
    const PAYMENT_PENDING = 'pending';

    public function frameData(PaymentTransaction $paymentTransaction): array;

    public function response(array $responseData);
}
