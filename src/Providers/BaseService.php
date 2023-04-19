<?php

declare(strict_types=1);

namespace Saeedeldeeb\PaymentGateway\Providers;

use GuzzleHttp\Client;
use Saeedeldeeb\PaymentGateway\Providers\UrWayService\UrWayClient;

abstract class BaseService
{
    /**
     * Store guzzle client instance.
     *
     * @var UrWayClient
     */
    protected $guzzleClient;

    /**
     * URWAY payment base path.
     *
     * @var string
     */
    protected $basePath;

    /**
     * Store URWAY payment endpoint.
     *
     * @var string
     */
    protected $endpoint;

    /**
     * set custom headers to make request to payment gateway service provider.
     */
    protected array $headers = [];

    /**
     * BaseService Constructor.
     */
    public function __construct()
    {
        $this->guzzleClient = new Client();
    }

    /**
     * @return string
     */
    public function getEndPointPath()
    {
        return $this->getBasePath() . 'BaseService.php/' . $this->endpoint;
    }


    protected function getBasePath()
    {
        return $this->basePath = config('payment.clickPay.base_bath');
    }
}
