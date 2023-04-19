<?php

declare(strict_types=1);

namespace Saeedeldeeb\PaymentGateway\Providers\UrWayService;

use Exception;
use Saeedeldeeb\PaymentGateway\Providers\BaseService;

class UrWayClient extends BaseService
{
    /**
     * @var string
     */
    protected $endpoint = 'URWAYPGService/transaction/jsonProcess/JSONrequest';

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
    public function setTrackId(string $trackId)
    {
        $this->attributes['trackid'] = $trackId;
        return $this;
    }

    /**
     * @param string|null $email
     * @return $this
     */
    public function setCustomerEmail(?string $email)
    {
        $this->attributes['customerEmail'] = $email;
        return $this;
    }

    /**
     * @return $this
     */
    public function setCustomerIp($ip)
    {
        $this->attributes['merchantIp'] = $ip;
        return $this;
    }

    /**
     * @return $this
     */
    public function setCurrency(string $currency)
    {
        $this->attributes['currency'] = $currency;
        return $this;
    }

    /**
     * @return $this
     */
    public function setCountry(string $country)
    {
        $this->attributes['country'] = $country;
        return $this;
    }

    /**
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->attributes['amount'] = $amount;
        return $this;
    }

    /**
     * @return $this
     */
    public function setRedirectUrl($url)
    {
        $this->attributes['udf2'] = $url;
        return $this;
    }

    /**
     * @return $this
     */
    public function setMerchantReference($merchantReference)
    {
        $this->attributes['udf1'] = $merchantReference;
        return $this;
    }

    /**
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function mergeAttributes(array $attributes)
    {
        $this->attributes = array_merge($this->attributes, $attributes);
        return $this;
    }

    /**
     * @param mixed $key
     * @param mixed $value
     *
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    /**
     * @param mixed $key
     *
     * @return boolean
     */
    public function hasAttribute($key)
    {
        return isset($this->attributes[$key]);
    }

    /**
     * @param $key
     * @return $this
     */
    public function removeAttribute($key)
    {
        $this->attributes = array_filter(
            $this->attributes,
            function ($name) use ($key) {
                return $name !== $key;
            },
            ARRAY_FILTER_USE_KEY
        );

        return $this;
    }

    /**
     * @return Response
     * @throws Exception
     */
    public function pay()
    {
        // According to documentation we have to send the `terminal_id`, and `password` now.
        $this->setAuthAttributes();

        // We have to generate request
        $this->generateRequestHash();

        try {
            $response = $this->guzzleClient->request(
                $this->method,
                $this->getEndPointPath(),
                [
                    'json' => $this->attributes,
                ]
            );

            return new Response((string)$response->getBody());
        } catch (\Throwable $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param string $transaction_id
     * @return Response
     * @throws Exception
     */
    public function find(string $transaction_id)
    {
        // According to documentation we have to send the `terminal_id`, and `password` now.
        $this->setAuthAttributes();

        // As requestHas for paying request is different from requestHash for find request.
        $this->generateFindRequestHash();

        $this->attributes['transid'] = $transaction_id;

        try {
            $response = $this->guzzleClient->request(
                $this->method,
                $this->getEndPointPath(),
                [
                    'json' => $this->attributes,
                ]
            );


            return new Response((string)$response->getBody());
        } catch (\Throwable $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return void
     */
    protected function generateRequestHash()
    {
        $this->hashRequest();
        $this->attributes['action'] = '1'; // I don't know why.
    }

    /**
     * @return void
     */
    protected function generateFindRequestHash()
    {
        $this->hashRequest();
        $this->attributes['action'] = '10'; // I don't know why.
    }

    /**
     * @return void
     */
    protected function setAuthAttributes()
    {
        $this->attributes['terminalId'] = config('payment.urway.auth.terminal_id');
        $this->attributes['password'] = config('payment.urway.auth.password');
    }

    /**
     * @return void
     */
    private function hashRequest(): void
    {
        $requestHash = $this->attributes['trackid'] . '|' . config('payment.urway.auth.terminal_id') . '|' . config(
                'payment.urway.auth.password'
            ) . '|' . config(
                'payment.urway.auth.merchant_key'
            ) . '|' . $this->attributes['amount'] . '|' . $this->attributes['currency'];
        $this->attributes['requestHash'] = hash('sha256', $requestHash);
    }
}
