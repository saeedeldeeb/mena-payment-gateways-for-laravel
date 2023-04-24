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
        $urway = PaymentGateway::gateway();
        $this->assertInstanceOf(UrWayGateway::class, $urway);
    }
}
