<?php

namespace Saeedeldeeb\PaymentGateway;

use Illuminate\Contracts\Foundation\Application;
use Saeedeldeeb\PaymentGateway\Contracts\PaymentGateway as PaymentGatewayInterface;

class PaymentGateway
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * The resolved gateway
     * @var PaymentGatewayInterface
     */
    protected $gateway;

    public function gateway(string|null $name = null)
    {
        $name = $name ?: $this->getDefaultDriver();
        return $this->gateway = $this->app[PaymentGatewayRegistry::class]
            ->get($name);
    }

    /**
     * Get the default cache driver name.
     *
     * @return string
     */
    public function getDefaultDriver(): string
    {
        return $this->app['config']['mena-payment-gateways-for-laravel.default'];
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
