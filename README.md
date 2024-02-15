# Database-ENV

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pdmfc/database-env.svg?style=flat-square)](https://packagist.org/packages/pdmfc/database-env)
[![Total Downloads](https://img.shields.io/packagist/dt/pdmfc/database-env.svg?style=flat-square)](https://packagist.org/packages/pdmfc/database-env)

## Installation

You can install the package via composer:

```bash
composer require pdmfc/database-env-php-8-support
```

## Usage

Add the DatabaseEnv `setConfig()` to `AppServiceProvider`

``` php
// app/Providers/AppServiceProvider.php
public function boot(): void
{
    DatabaseEnv::setConfig();
    ...
}
```

Run the DatabaseEnv `migration`

```bash
php artisan migrate
```

Run the DatabaseEnv command `database-env:add` to add the key=value pair variable of .env to database

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email vhugo@vitorhugo.pt instead of using the issue tracker.

## Credits

- [Vitor Hugo](https://github.com/pdmfc)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
