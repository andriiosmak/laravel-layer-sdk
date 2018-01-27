# Layer SDK for Laravel 5

[![Build Status](https://travis-ci.org/andriiosmak/laravel-layer-sdk.svg)](https://travis-ci.org/andriiosmak/laravel-layer-sdk)
![Downloads][ico-downloads]
![Stable][ico-stable]
![Unstable][ico-unstable]
[![Software License][ico-license]](LICENSE.md)

The Layer SDK for Laravel 5 is a library with powerful features that enable PHP developers to easily make requests to [Layer Server API](https://docs.layer.com/reference/server_api/introduction). Despite the fact this package was designed to be easily integrated to projects based on Laravel 5.5+ framework, it can be integrated to projects based on other web frameworks.

- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [Security](#security)
- [Credits](#credits)
- [License](#license)

## Requirements

* "php": "~7.2",
* "illuminate/support": "~5.5",
* "illuminate/container": "~5.5",
* "guzzlehttp/guzzle": "~6.3"

## Installation

### Composer

> composer require aosmak/laravel-layer-sdk

### Service Provider

Add the package to your application service providers in config/app.php file.

``` php
'providers' => [

    /*
     * Laravel Framework Service Providers...
     */
    Illuminate\Foundation\Providers\ArtisanServiceProvider::class,
    Illuminate\Auth\AuthServiceProvider::class,
    ...

    /**
     * Third Party Service Providers...
     */
    Aosmak\Laravel\Layer\Sdk\LayerProvider::class,

],
```

### Config File

Publish the package config file to your application. Run this command inside your terminal.

> php artisan vendor:publish --provider="Aosmak\Laravel\Layer\Sdk\LayerProvider" --tag=config

Put your application ID and auth token in config/layer.php.

``` php
return [
    'LAYER_SDK_APP_ID'           => env('LAYER_SDK_APP_ID', '-YOUR_APP_ID-'),
    'LAYER_SDK_AUTH'             => env('LAYER_SDK_AUTH', '-YOUR_APP_AUTH_TOKEN-'),
    'LAYER_SDK_BASE_URL'         => env('LAYER_SDK_BASE_URL', 'https://api.layer.com/apps/'),
    'LAYER_SDK_SHOW_HTTP_ERRORS' => env('LAYER_SDK_SHOW_HTTP_ERRORS', false),
    'LAYER_SDK_API_VERSION'      => env('LAYER_SDK_API_VERSION', '3.0')
];
```
Don`t have an account? Click [here](https://dashboard.layer.com/login) to sign up.

## Usage

Full documentation can be found [here](https://github.com/andriiosmak/laravel-layer-sdk/wiki).

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email andrii.osmak.dev@gmail.com instead of using the issue tracker.

## Credits

- [Andrii Osmak][link-author]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-author]: https://github.com/andriiosmak
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg
[ico-downloads]: https://img.shields.io/packagist/dt/aosmak/laravel-layer-sdk.svg
[ico-stable]: https://poser.pugx.org/aosmak/laravel-layer-sdk/v/stable.svg
[ico-unstable]: https://poser.pugx.org/aosmak/laravel-layer-sdk/v/unstable.svg