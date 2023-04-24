<?php

namespace Saeedeldeeb\PaymentGateway;

use Illuminate\Contracts\Foundation\Application;
use Saeedeldeeb\PaymentGateway\Contracts\PaymentGateway as PaymentGatewayInterface;

class PaymentGateway
{
    /**
     * The resolved gateway
     * @var PaymentGatewayInterface
     */
    protected $gateway;

    public function gateway(string|null $name = null)
    {
        $name = $name ?: $this->getDefaultGateway();
        return $this->gateway = app(PaymentGatewayRegistry::class)
            ->get($name);
    }

    /**
     * Get the default cache driver name.
     *
     * @return string
     */
    public function getDefaultGateway(): string
    {
        return app()['config']['mena-payment-gateways-for-laravel.default'];
    }

    /**
     * Dynamically call the default driver instance.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->gateway()->$method(...$parameters);
    }
}
