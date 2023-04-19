<?php

declare(strict_types=1);

namespace Saeedeldeeb\PaymentGateway\Providers\ClickPayService;

use Saeedeldeeb\PaymentGateway\Providers\BaseService;
use Exception;

class ClickPayClient extends BaseService
{
    /**
     * @var string
     */
    protected $endpoint = 'payment/request';

    /**
     * Request method.
     *
     * @var string
     */
    protected string $method = 'POST';

    /**
     * Store request attributes.
     *
     * @var array
     */
    protected array $attributes = [];

    /**
     * @return $this
     */
    public function __construct()
    {
        parent::__construct();
        $this->attributes['profile_id'] = config('payment.clickPay.profile_id');
        $this->attributes['cart_currency'] = config('payment.default_currency');
        $this->attributes['tran_type'] = PaymentEnums::CLICK_PAY_DEFAULT_TRANSACTION_TYPE;
        $this->attributes['tran_class'] = PaymentEnums::CLICK_PAY_DEFAULT_TRANSACTION_CLASS;
        $this->attributes['customer_details'] = [
//            'name' => 'test',
//            'email' => 'example' . randString(3) . '@example.com',
            'phone' => '0096655555555',
            'street1' => 'test',
            'city' => 'riyadh',
            'state' => 'riyadh',
            'country' => 'SA',
            'zip' => '12345',
            'ip' => request()->ip(),
        ];
//        $this->attributes['framed'] = true;
        $this->attributes['hide_shipping'] = true;
        $this->headers = [
            'headers' => [
                'Authorization' => config('payment.clickPay.server_key'),
                'Content-Type' => 'application/json',
            ],
        ];
    }

    /**
     * @return $this
     */
    public function setCartId(string $transactionId): static
    {
        $this->attributes['cart_id'] = $transactionId;
        return $this;
    }

    /**
     * @return $this
     */
    public function setCartDescription(PaymentTransaction $paymentTransaction): static
    {
        $this->attributes['cart_description'] = $paymentTransaction?->donation?->initiative?->title ??
            PaymentEnums::CLICK_PAY_DEFAULT_TRANSACTION_Description;
        return $this;
    }

    /**
     * @return $this
     */
    public function setCartAmount($mount): static
    {
        $this->attributes['cart_amount'] = $mount;
        return $this;
    }

    /**
     * @return $this
     */
    public function setRedirectionUrl(): static
    {
        $this->attributes['callback'] = route('api.payments.visitor.gateway.response', ['language' => 'ar']);
        $this->attributes['return'] = route('api.payments.visitor.gateway.redirection', ['language' => 'ar']);
        return $this;
    }

    /**
     * @throws Exception
     */
    public function getTransactionsUrl($data): string
    {
        $this->setCartId($data['cart_id'])
            ->setCartAmount($data['mount'])
            ->setCartDescription($data['transaction'])
            ->setRedirectionUrl();
        $response = $this->makeRequest();
        if (!empty($response['redirect_url'])) {
            // update transaction id by click pay transaction id
            $transaction = PaymentTransaction::query()->where('uuid', $data['cart_id'])->first();
            $transaction->update(['transaction_id', $response['tran_ref']]);
            return $response['redirect_url'];
        }
        throw new Exception($response['message']);
    }

    /**
     * @throws Exception
     */
    private function makeRequest()
    {
        $options = [
            'json' => $this->attributes,

        ];
        if (count($this->headers)) {
            $options = array_merge($options, $this->headers);
        }
        try {
            $response = $this->guzzleClient->request(
                $this->method,
                $this->getEndPointPath(),
                $options
            );
            return json_decode((string)$response->getBody(), true);
        } catch (\Throwable $e) {
            throw new Exception($e->getMessage());
        }
    }
}
