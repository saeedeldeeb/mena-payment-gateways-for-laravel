<?php

namespace Saeedeldeeb\PaymentGateway\Contracts;

interface PayableOrder
{

    /**
     * @return string
     */
    public function getPaymentOrderId(): string;

    /**
     * @return float
     */
    public function getPaymentAmount(): float;

    /**
     * @return string
     */
    public function getPaymentDescription(): string;

    /**
     * @return string
     */
    public function getCustomerEmail(): string;

    /**
     * @return string
     */
    public function getCustomerLanguage(): string;

    /**
     * @return array
     */
    public function getCustomerExtras(): array;
}
