<?php

declare(strict_types=1);

namespace Saeedeldeeb\PaymentGateway\Providers\UrWayService;

class Response
{
    /**
     * Store the response data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Response constructor.
     */
    public function __construct($response)
    {
        $this->data = json_decode($response, true);
    }

    /**
     * @return array|mixed
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * @return false|string
     */
    public function getPaymentUrl()
    {
        if (!empty($this->data['payid']) && !empty($this->data['targetUrl'])) {
            return $this->data['targetUrl'] . '?paymentid=' . $this->data['payid'];
        }

        return false;
    }

    /**
     * @return boolean
     */
    public function isSuccess()
    {
        return $this->data['result'] == 'Successful' && $this->data['responseCode'] == '000';
    }

    /**
     * @return bool
     */
    public function isFailure()
    {
        return !$this->isSuccess();
    }

    /**
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data[$name];
    }
}
