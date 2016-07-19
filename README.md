# Layer SDK for Laravel 5

![Build Status][ico-travis]
![Downloads][ico-downloads]
![Stable][ico-stable]
![Unstable][ico-unstable]
[![Software License][ico-license]](LICENSE.md)

Powerful package that helps Larevel 5 projects to access Layer Services ([layer.com][link-layer]).

- [Installation](#installation)
- [Usage](#usage)
    - [Users](#users)
    - [Conversations](#conversations)
    - [Messages](#messages)
    - [Announcements](#announcements)
- [Contributing](#contributing)
- [Security](#security)
- [Credits](#credits)
- [License](#license)

## Installation

Composer

``` bash
$ composer require aosmak/laravel-layer-sdk
```

Service Provider

Add the package to your application service providers in config/app.php file.

``` bash
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
    Aosmak\Layer\LayerProvider::class,

],
```

Config File

Publish the package config file to your application. Run this command inside your terminal.

``` bash
php artisan vendor:publish --provider="Aosmak\Layer\LayerProvider" --tag=config
```

Put your application ID and auth token in config/layer.php.

``` bash
return [
    'LAYER_SDK_APP_ID'           => env('LAYER_SDK_APP_ID', '-YOUR_APP_ID-'),
    'LAYER_SDK_AUTH'             => env('LAYER_SDK_AUTH', '-YOUR_APP_AUTH_TOKEN-'),
    'LAYER_SDK_BASE_URL'         => env('LAYER_SDK_BASE_URL', 'https://api.layer.com/apps/'),
    'LAYER_SDK_SHOW_HTTP_ERRORS' => env('LAYER_SDK_SHOW_HTTP_ERRORS', false),
];
```
Don`t have an account? Click [here][link-signup-layer] to sign up.

## Usage

###Users

Usage in controller

``` php
use Aosmak\Layer\Services\LayerServiceInterface;

class Controller
{
    public function test(LayerServiceInterface $layer)
    {
    	$userService = $layer->getUserService();
    	$result      = $userService->get('userId');

    	var_dump($result);
    }
}
```

Create a user

``` php
$data = [
    "first_name"   => 'testName',
    "last_name"    => 'testSurname',
    "display_name" => 'testDisplayName',
    "phone_number" => 'testPhoneNumber',
];

$result = $layer->getUserService()->create($data, 'testUserOne');

echo $result; //true
```

Replace a user

``` php
$data = [
    "first_name"   => 'testNameReplacement',
    "last_name"    => 'testSurnameReplacement',
    "display_name" => 'testDisplayNameReplacement',
    "phone_number" => 'testPhoneNumberReplacement',
];

$result = $layer->getUserService()->replace($data, 'testUserOne');

echo $result; //true
```

Update a user

``` php
$data = [
    [
        'operation' => 'set',
        'property'  => 'last_name',
        'value'     => 'test921',
    ],
];

$result = $layer->getUserService()->update($data, 'testUserOne');

echo $result; //true
```

Get user details

``` php
$result = $layer->getUserService()->get('userId');

echo $result; //array
```

Delete a user

``` php
$result = $layer->getUserService()->delete('userId');

echo $result; //true
```

Additional information you can find [here][link-layer-documentation-user].

###Conversations

Create a conversation

``` php
$id = $layer->getConversationService()->create([
    'participants' => [
        "userId1",
        "userId2",
    ],
]);
```

Update a conversation

``` php
$result = $this->getConversationService()->update([
    [
        'operation' => 'set',
        'property'  => 'participants',
        'value'     =>  ["userId1", "userId2", "userId3"],
    ],
], 'conversationID');
echo $result; //true
```

Get conversation details

``` php
$result = $layer->getConversationService()->get('conversationID');

echo $result; //array
```

Get all conversations by user ID

``` php
$result = $layer->getConversationService()->all('userId1');

echo $result; //array
```

Delete a conversation

``` php
$result = $layer->getConversationService()->delete('conversationID');

echo $result; //true
```

Additional information you can find [here][link-layer-documentation-conversation].

###Messages

Create a message

``` php
$data = [
    'sender' => [
        "user_id" => "userId1",
    ],
    'parts' => [
        [
            'body'      => 'Hello, World!',
            'mime_type' => 'text/plain'
        ],
    ],
];

$result = $layer->getMessageService()->create($data, 'conversationID');

echo $result; //true
```

Get messages (system)

``` php
$result = $layer->getMessageService()->allLikeSystem('conversationID');

echo $result; //array
```

Get messages (user)

``` php
$result = $layer->getMessageService()->allLikeUser('conversationID', 'userId');

echo $result; //array
```

Get a message (system)

``` php
$result = $layer->getMessageService()->getLikeSystem('messageId', 'conversationID');

echo $result; //array
```

Get a message (user)

``` php
$result = $layer->getMessageService()->getLikeUser('messageId', 'userId');

echo $result; //array
```

Delete a message

``` php
$result = $layer->getMessageService()->delete('messageId', 'conversationID');

echo $result; //true
```

Additional information you can find [here][link-layer-documentation-message].

###Announcements

Create an announcement

``` php
$data = [
    'recipients' => [
        "userId1",
        "userId2",
    ],
    'sender' => [
        'name' => 'The System',
    ],
    'parts' => [
        [
            'body'      => 'Hello, World!',
            'mime_type' => 'text/plain'
        ],
    ],
];

$result = $layer->getAnnouncementService()->create($data);
echo $result //string
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email aoworld@meta.ua instead of using the issue tracker.

## Credits

- [Andrii Osmak][link-author]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-author]: https://github.com/andriiosmak
[link-layer]: https://layer.com
[link-signup-layer]: https://developer.layer.com/signup
[link-layer-documentation-user]: https://developer.layer.com/docs/platform/users#identity
[link-layer-documentation-conversation]: https://developer.layer.com/docs/platform/conversations#retrieve-a-conversation
[link-layer-documentation-message]: https://developer.layer.com/docs/platform/messages#send-a-message

[ico-version]: https://img.shields.io/packagist/v/aosmak/laravel-layer-sdk.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/andriiosmak/laravel-layer-sdk/master.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/aosmak/laravel-layer-sdk.svg?style=flat-square
[ico-stable]: https://poser.pugx.org/aosmak/laravel-layer-sdk/v/stable.svg
[ico-unstable]: https://poser.pugx.org/aosmak/laravel-layer-sdk/v/unstable.svg

[link-packagist]: https://packagist.org/packages/aosmak/laravel-layer-sdk
[link-travis]: https://travis-ci.org/:vendor/:package_name
[link-downloads]: https://packagist.org/packages/aosmak/laravel-layer-sdk
[link-contributors]: ../../contributors
