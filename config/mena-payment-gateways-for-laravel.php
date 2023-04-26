<?php

// config for Saeedeldeeb/PaymentGateway
return [
    /*
    |--------------------------------------------------------------------------
    | Default Payment Gateway
    |--------------------------------------------------------------------------
    |
    | This option controls the default payment gateway that will be used to process
    | payments for your application. By default, the urway gateway is
    | used; however, you remain free to modify this option if you wish.
    |
    | Supported: "urway", "clickPay"
    |
    */

    'default' => env('DEFAULT_GATEWAY', 'urway'),

    /*
    |--------------------------------------------------------------------------
    | UrWay Option
    |--------------------------------------------------------------------------
    |
    | Here you may specify the configuration options that should be used when
    | payments are processed using the UrWay gateway. This will allow you
    | to control the service to complete payments.
    |
    */
    'urway' => [
        'base_path' => env('URWAY_BASE'),
        'auth' => [
            'terminal_id' => env('URWAY_TERMINAL_ID'),
            'password' => env('URWAY_PASSWORD'),
            'merchant_key' => env('URWAY_MERCHANT_KEY'),
        ],
    ],
    'clickpay' => [
        'base_path' => env('CLICK_PAY_BASE_URL'),
        'server_key' => env('CLICK_PAY_SERVER_KEY'),
        'profile_id' => env('CLICK_PAY_PROFILE_ID'),
    ],
    'default_currency' => env('DEFAULT_CURRENCY', "SAR")
];
