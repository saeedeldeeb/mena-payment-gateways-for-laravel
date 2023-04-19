<?php

namespace Saeedeldeeb\PaymentGateway;

use Exception;
use Saeedeldeeb\PaymentGateway\Contracts\PaymentGateway as PaymentGatewayInterface;

class PaymentGatewayRegistry
{
    protected array $gateways = [];

    public function register($name, PaymentGatewayInterface $instance)
    {
        $this->gateways[$name] = $instance;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function get($name)
    {
        if (array_key_exists($name, $this->gateways)) {
            return $this->gateways[$name];
        } else {
            throw new Exception("Invalid gateway");
        }
    }
}
