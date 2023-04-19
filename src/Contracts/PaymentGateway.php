<?php

namespace Saeedeldeeb\PaymentGateway\Contracts;

interface PaymentGateway
{
    const PAYMENT_RESULT_COMPLETED = 'completed';
    const PAYMENT_RESULT_DECLINED = 'declined';
    const PAYMENT_RESULT_CANCELED = 'canceled';
    const PAYMENT_RESULT_FAILED = 'failed';
    const PAYMENT_PENDING = 'pending';

    /**
     * Set the order to be paid.
     *
     * @param PayableOrder $order
     *
     * @return PaymentGateway
     */
    public function setOrder(PayableOrder $order);

    /**
     * Get the payment form.
     *
     * @return string
     */
    public function getPaymentForm();

    /**
     * Determine the result of the payment
     * If gatewayResponse is null, Input::all() will be used.
     *
     * @param null $gatewayResponse
     *
     * @return string
     */
    public function getPaymentResult($gatewayResponse = null);
}
