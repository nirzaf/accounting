# Currency formatting and conversion package for Laravel.

[![Version](https://poser.pugx.org/akaunting/money/v/stable.svg)](https://github.com/akaunting/money/releases)
![Downloads](https://poser.pugx.org/akaunting/money/d/total.svg)
![Build Status](https://travis-ci.com/akaunting/money.svg)
[![StyleCI](https://styleci.io/repos/112121508/shield?style=flat&branch=master)](https://styleci.io/repos/112121508)
[![Quality](https://scrutinizer-ci.com/g/akaunting/money/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/akaunting/money)
[![License](https://poser.pugx.org/akaunting/money/license.svg)](LICENSE.md)

This package intends to provide tools for formatting and conversion monetary values in an easy, yet powerful way for Laravel projects.

### Why not use the moneyphp package?

Because `moneyphp` uses the `intl` extension for number formatting. `intl` extension isn't present by default on PHP installs and can give [different results](http://moneyphp.org/en/latest/features/formatting.html#intl-formatter) in different servers.

## Getting Started

### 1. Install

Run the following command:

```bash
composer require akaunting/money
```

### 2. Register (for Laravel < 5.5)

Register the service provider in `config/app.php`

```php
Akaunting\Money\Provider::class,
```

### 3. Publish

Publish config file.

```bash
php artisan vendor:publish --tag=money
```


### 4. Configure

You can change the currencies information of your app from `config/money.php` file

## Usage

```php
use Akaunting\Money\Currency;
use Akaunting\Money\Money;

echo Money::USD(500); // '$5.00' unconverted
echo new Money(500, new Currency('USD')); // '$5.00' unconverted
echo Money::USD(500, true); // '$500.00' converted
echo new Money(500, new Currency('USD'), true); // '$500.00' converted
```

### Advanced

```php
$m1 = Money::USD(500);
$m2 = Money::EUR(500);

$m1->getCurrency();
$m1->isSameCurrency($m2);
$m1->compare($m2);
$m1->equals($m2);
$m1->greaterThan($m2);
$m1->greaterThanOrEqual($m2);
$m1->lessThan($m2);
$m1->lessThanOrEqual($m2);
$m1->convert(Currency::GBP, 3.5);
$m1->add($m2);
$m1->subtract($m2);
$m1->multiply(2);
$m1->divide(2);
$m1->allocate([1, 1, 1]);
$m1->isZero();
$m1->isPositive();
$m1->isNegative();
$m1->format();
```

### Helpers

```php
money(500, 'USD')
currency('USD')
```

### Blade Directives

```php
@money(500, 'USD')
@currency('USD')
```

## Changelog

Please see [Releases](../../releases) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email security@akaunting.com instead of using the issue tracker.

## Credits

- [Denis Duliçi](https://github.com/denisdulici)
- [Ricardo Gobbo de Souza](https://github.com/ricardogobbosouza)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [LICENSE](LICENSE.md) for more information.
