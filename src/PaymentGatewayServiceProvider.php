<?php

namespace Saeedeldeeb\PaymentGateway;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Saeedeldeeb\PaymentGateway\Commands\PaymentGatewayCommand;

class PaymentGatewayServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('mena-payment-gateways-for-laravel')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_mena-payment-gateways-for-laravel_table')
            ->hasCommand(PaymentGatewayCommand::class);
    }
}
