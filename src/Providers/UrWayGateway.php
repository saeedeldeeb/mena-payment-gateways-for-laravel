<?php

namespace Saeedeldeeb\PaymentGateway\Providers;

use Illuminate\View\View;
use Saeedeldeeb\PaymentGateway\Contracts\PayableOrder;
use Saeedeldeeb\PaymentGateway\Providers\UrWayService\UrWayClient;
use Exception;
use Saeedeldeeb\PaymentGateway\Contracts\PaymentGateway as PaymentGatewayInterface;

class UrWayGateway implements PaymentGatewayInterface
{
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

    public function getPaymentForm()
    {
        $data = [
            'sender_name' => config('payment.sender_name'),
            'merchant_reference' => $this->order->getPaymentOrderId(),
            'amount' => $this->order->getPaymentAmount(),
            'currency' => config('payment.urway.currency'),
            'merchant_extra' => $this->order->getCustomerExtras(),
            'customer_email' => $this->order->getCustomerEmail(),
            'language' => $this->order->getCustomerLanguage(),
            'customer_ip' => request()->ip(),
            'track_id' => rand()          // track_id is the transaction id in our side
        ];
        $returnData = $this->paymentRequest($data);

        $data['url'] = $returnData->getPaymentUrl();
        return View::make('urway.form')->with(compact('data'));
    }

    public function getPaymentResult($gatewayResponse = null)
    {
        return $this->checkResponseStatus($gatewayResponse);
    }

    /**
     * @throws Exception
     */
    private function paymentRequest($data)
    {
        $request = new UrWayClient();
        $request->setTrackId($data['track_id'])
            ->setCustomerEmail($data['customer_email'])
            ->setCurrency($data['currency'])
            ->setCountry('SA')
            ->setAmount($data['amount'])
            ->setAttribute("udf3", $data['language'])
            ->setAttribute('udf1', $data['merchant_reference'] ?? null)
            ->setAttribute('First_name', $data['sender_name'])
            ->setAttribute('udf2', $data['merchant_extra1'] ?? null)
            ->setAttribute('udf4', $data['merchant_extra2'] ?? null)
            ->setRedirectUrl(route('api.payments.visitor.gateway.response', ['language' => 'ar']))
            ->setCustomerIp($data['customer_ip']);

        return $request->pay();
    }

    /**
     * @throws Exception
     */
    protected function checkResponseStatus(array $request)
    {
        $client = new UrWayClient();
        $client->setTrackId($request['TrackId']);
        $client->setAmount($request['amount'])
            ->setCustomerEmail($request['email'])
            ->setCurrency(config('payment.urway.currency'))
            ->setCountry('SA');
        return $client->find($request['TranId']);
    }
}
