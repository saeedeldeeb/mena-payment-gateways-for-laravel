<?php

namespace Saeedeldeeb\PaymentGateway;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Support\DeferrableProvider;
use Saeedeldeeb\PaymentGateway\Providers\ClickPayGateway;
use Saeedeldeeb\PaymentGateway\Providers\UrWayGateway;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Saeedeldeeb\PaymentGateway\Commands\PaymentGatewayCommand;

class PaymentGatewayServiceProvider extends PackageServiceProvider implements DeferrableProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('mena-payment-gateways-for-laravel')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_mena-payment-gateways-for-laravel_table')
            ->hasCommand(PaymentGatewayCommand::class);
    }

    /**
     * @return void
     */
    public function registeringPackage()
    {
        $this->app->singleton(PaymentGatewayRegistry::class);
    }

    /**
     * @return void
     * @throws BindingResolutionException
     */
    public function bootingPackage()
    {
        $this->app->make(PaymentGatewayRegistry::class)
            ->register("urway", $this->app->make(UrWayGateway::class))
            ->register("clickpay", $this->app->make(ClickPayGateway::class))
        ;
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [PaymentGatewayRegistry::class];
    }
}
