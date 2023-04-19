<?php

namespace Saeedeldeeb\PaymentGateway\Providers;

use Illuminate\View\View;
use Saeedeldeeb\PaymentGateway\Contracts\PayableOrder;
use Saeedeldeeb\PaymentGateway\Providers\ClickPayService\ClickPayClient;
use Exception;
use Saeedeldeeb\PaymentGateway\Contracts\PaymentGateway as PaymentGatewayInterface;

class ClickPayGateway implements PaymentGatewayInterface
{
    const CLICK_PAY_DEFAULT_TRANSACTION_TYPE = 'sale';
    const CLICK_PAY_DEFAULT_TRANSACTION_CLASS = 'ecom';
    const CLICK_PAY_DEFAULT_TRANSACTION_Description = 'Donation';
    const CLICK_PAY_SUCCESS_STATUS = 'A';

    protected PayableOrder $order;

    /**
     * Set the payable order.
     *
     * @param PayableOrder $order
     *
     * @return PaymentGatewayInterface
     */
    public function setOrder(PayableOrder $order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * Get the payment form.
     *
     * @return string
     * @throws Exception
     */
    public function getPaymentForm()
    {
        $clickPayObj = new ClickPayClient();
        $data = [
            'cart_id' => $this->order->getPaymentOrderId(),
            'mount' => $this->order->getPaymentAmount(),
            'transaction' => $this->order->getCustomerExtras(),
        ];
        $data['url'] = $clickPayObj->getTransactionsUrl($data);
        return View::make('clickpay.form')->with(compact('data'));
    }

    public function getPaymentResult(array $gatewayResponse = null)
    {
        return $gatewayResponse;
    }
}
