# This is my package mena-payment-gateways-for-laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/saeedeldeeb/mena-payment-gateways-for-laravel.svg?style=flat-square)](https://packagist.org/packages/saeedeldeeb/mena-payment-gateways-for-laravel)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/saeedeldeeb/mena-payment-gateways-for-laravel/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/saeedeldeeb/mena-payment-gateways-for-laravel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/saeedeldeeb/mena-payment-gateways-for-laravel/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/saeedeldeeb/mena-payment-gateways-for-laravel/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/saeedeldeeb/mena-payment-gateways-for-laravel.svg?style=flat-square)](https://packagist.org/packages/saeedeldeeb/mena-payment-gateways-for-laravel)

Package for payment gateway providers that operates in the Middle East and North Africa (MENA) region.

## Installation

You can install the package via composer:

```bash
composer require saeedeldeeb/mena-payment-gateways-for-laravel
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="mena-payment-gateways-for-laravel-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$paymentGateway = new Saeedeldeeb\PaymentGateway();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Saeed Eldeeb](https://github.com/saeedeldeeb)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
