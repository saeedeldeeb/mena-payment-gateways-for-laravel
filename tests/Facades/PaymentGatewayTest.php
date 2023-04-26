<?php

namespace Saeedeldeeb\PaymentGateway\Tests\Facades;

use Saeedeldeeb\PaymentGateway\Facades\PaymentGateway;
use Saeedeldeeb\PaymentGateway\Providers\UrWayGateway;
use Saeedeldeeb\PaymentGateway\Tests\TestCase;

class PaymentGatewayTest extends TestCase
{
    /**
     * @test
     */
    public function test_facade_can_get_default_gateway()
    {
        config()->set('mena-payment-gateways-for-laravel.default', 'urway');
        $urway = PaymentGateway::gateway();
        $this->assertInstanceOf(UrWayGateway::class, $urway);
    }
}
