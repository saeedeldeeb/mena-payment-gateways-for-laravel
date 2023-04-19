<?php

namespace Saeedeldeeb\PaymentGateway\Providers;

use Saeedeldeeb\PaymentGateway\Providers\UrWayService\UrWayClient;
use Exception;
use Saeedeldeeb\PaymentGateway\Contracts\PaymentGateway;
use Saeedeldeeb\PaymentGateway\PaymentTransaction;

class UrWayGateway implements PaymentGateway
{
    /**
     * @param PaymentTransaction $paymentTransaction
     * @return array
     * @throws Exception
     */
    public function frameData(PaymentTransaction $paymentTransaction): array
    {
        $data = [
            'sender_name' => 'Afaq',
            'merchant_reference' => $paymentTransaction->merchant_reference,
            'amount' => $paymentTransaction->amount,
            'currency' => config('payment.urway.currency'),
            'merchant_extra' => $paymentTransaction->uuid,
            'customer_email' => config('app.support_email'),
            'language' => app()->getLocale(),
            'customer_ip' => request()->ip(),
            'track_id' => rand()          // track_id is the transaction id in our side
        ];
        $returnData = $this->paymentRequest($data);

        $paymentTransaction->transaction_id = $returnData->payid ?? null;
        $paymentTransaction->track_id = $data['track_id'];
        $paymentTransaction->save();

        $data['url'] = $returnData->getPaymentUrl();
        return $data;
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
     * @param array $responseData
     * @return mixed
     * @throws Exception
     */
    public function response(array $responseData)
    {
        $response = $this->checkResponseStatus($responseData);

        $transaction = tap(
            PaymentTransaction::query()
                ->where('merchant_reference', $response->udf1)->first()
        )
            ->update(['status' => $response->responseCode == 000 ? 'Completed' : 'Failed']);
        return $transaction->refresh();
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
