<?php

namespace Saeedeldeeb\PaymentGateway\Commands;

use Illuminate\Console\Command;

class PaymentGatewayCommand extends Command
{
    public $signature = 'mena-payment-gateways-for-laravel';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
