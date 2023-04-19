<?php

namespace Saeedeldeeb\PaymentGateway\Providers;

use Saeedeldeeb\PaymentGateway\Providers\ClickPayService\ClickPayClient;
use Exception;
use Illuminate\Support\Facades\DB;
use Saeedeldeeb\PaymentGateway\Contracts\PaymentGateway;
use Saeedeldeeb\PaymentGateway\PaymentTransaction;

class ClickPayGateway implements PaymentGateway
{
    /**
     * @throws Exception
     */
    public function frameData(PaymentTransaction $paymentTransaction): array
    {
        $clickPayObj = new ClickPayClient();
        $data = [
            'cart_id' => $paymentTransaction->uuid,
            'mount' => $paymentTransaction->amount,
            'transaction' => $paymentTransaction,
        ];
        $data['url'] = $clickPayObj->getTransactionsUrl($data);
        return $data;
    }

    public function response(array $responseData)
    {
        try {
            $transaction = PaymentTransaction::query()
                ->find($responseData['cart_id']);
            $paymentStatusCode = $responseData['payment_result']['response_status'];
            if (isset($transaction) && $transaction->status == PaymentEnums::PENDING) {
                DB::beginTransaction();
                $transaction = tap($transaction)
                    ->update(
                        [
                            'status' =>
                                $paymentStatusCode == PaymentEnums::CLICK_PAY_SUCCESS_STATUS ?
                                    PaymentEnums::COMPLETED : PaymentEnums::FAILED,
                        ]
                    );
                DB::commit();
                return $transaction->refresh();
            }
        } catch (Exception $e) {
            DB::rollBack();
        }
        return null;
    }
}
