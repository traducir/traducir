
# Traducir

## Introduction
A Nice PHP Translation package, Which use popular Translation API providers like Google, Yandex ..

## Requirements
- Guzzlehttp 6.0
- PHP version 5.4 and later
- Laravel version 5.* and later

## Installation
You can install the library via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require traducir/traducir
```

## Providers

Provider  | Translate  | Detect  | Languages  |  Documentations
--|---|---|---|--
Google  |  Yes | Yes  | Yes  |  https://cloud.google.com/translate/docs/
Yandex  | Yes  | Yes  | Yes  |  https://tech.yandex.com/translate/doc/dg/concepts/About-docpage/
Deepl  | Yes  | No  | No  |  https://www.deepl.com/api.html
Frengly  | Yes  | No  | No  |  http://www.frengly.com/api


## Laravel
Publishing the Configuration File

`path/to/laravel/config/translator.php`

```bash
php artisan vendor:publish
```

For older versions of laravel you have to load ServiceProvider and Facade Manually.

`path/to/laravel/config/app.php`

```php
<?php

'providers' => [
        ......
        Traducir\Traducir\TranslatorServiceProvider::class,
        ......
    ],

'aliases' => [
        ......
        'Translator' => Traducir\Traducir\TranslatorFacade::class,
        ......
    ],
```

## Examples

### 1. Standalone Example

```php
<?php

use Traducir\Traducir\Translator;

$config = [
  'key' => 'YOUR_API_KEY',
  'format' => 'text',
  'from' => 'fr',
  'to' => 'en',
];

$translator = new translator($config);

$translator->driver('google');

$translator->translate('bonjour');
```

### 2. Laravel Example

```php
<?php

$translator = Translator::driver('google');

$translator->text('bonjour');
```

## Documentation
See https://traducir.github.io/ for the full online documentation.

## Contribution
For any contribution, Please hit a pull request.
Mail me at mail@deyaa.me    


## License

Traducir is open-sourced software licensed under the MIT license.
