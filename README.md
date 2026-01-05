# ean-utils

PHP library to generate and validate `EAN-8` and `EAN-13` barcodes.

## 📖 Requirements
PHP 7.0 or higher

## 📦 Installing

```shell
$ composer require richarddobron/ean-utils
```

## ⚡️ Usage

### Builder
```php
use dobron\EanUtils\Ean13Generator;
use dobron\EanUtils\Ean8Generator;

$ean13 = new Ean13Generator();

$ean13->generate('1234567', '500'); // 5000012345675
$ean13->generate('1234567'); // 0000012345670

$ean8 = new Ean8Generator();

$ean8->generate('123', '212'); // 21201233
$ean8->generate('123'); // 00001236
```

### Validator
```php
use dobron\EanUtils\EanValidator;

$eanValidator = new EanValidator();

$eanValidator->validate('5000012345675'); // true

$eanValidator->validate('1234567'); // false

$eanValidator->validate('ABCDEFGH'); // false
```

## 🤝 Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## 📜 License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
