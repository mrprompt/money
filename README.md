# Money

Library to made work with currency and money easy.

### Install

```console
composer install mrprompt/money
```

### Use

```php
use MrPrompt\Money\Currency;

$money = new Currency('BRL');
$money->code(); // return the code (the same passed at constructor)
$money->number(); // return the code as number, like 960.
$money->name(); // return the currency name, like Real
$money->countries(); // return the countries that use the currency
$money->decimals(); // return the decimals used by the currency
$money->format(1.00); // format the currency
```

### License

GPLv3