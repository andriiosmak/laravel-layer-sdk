# Layer SDK for Laravel 5

[![Build Status](https://travis-ci.org/andriiosmak/laravel-layer-sdk.svg)](https://travis-ci.org/andriiosmak/laravel-layer-sdk)
![Downloads][ico-downloads]
![Stable][ico-stable]
![Unstable][ico-unstable]
[![Software License][ico-license]](LICENSE.md)

Powerful package that helps Laravel 5 projects to access Layer Services ([layer.com][link-layer]).

- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
    - [Users](#users)
    - [Accessing user data](#accessing_user_data)
    - [Conversations](#conversations)
    - [Messages](#messages)
    - [Announcements](#announcements)
    - [Notifications](#notifications)
- [Contributing](#contributing)
- [Security](#security)
- [Credits](#credits)
- [License](#license)

## Requirements

- PHP 7.2 +
- Laravel 5.2 +

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
    Aosmak\Laravel\Layer\Sdk\LayerProvider::class,

],
```

Config File

Publish the package config file to your application. Run this command inside your terminal.

``` bash
php artisan vendor:publish --provider="Aosmak\Laravel\Layer\Sdk\LayerProvider" --tag=config
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

Basic example

``` php
use Aosmak\Laravel\Layer\Sdk\Services\LayerServiceInterface;

class Controller
{
    /**
     * Test method
     *
     * @param \Aosmak\Laravel\Layer\Sdk\Services\LayerService $layer
     *
     * @return void
     */
    public function test(LayerServiceInterface $layer): void
    {
        $userService = $layer->getUserService();
        $response    = $userService->get('userId');

        //get response status code
        echo $response->getStatusCode(); //integer

        //get response contents
        echo $response->getContents(); //array
    }
}
```

### Users

Create a user

``` php
$data = [
    "first_name"   => 'testName',
    "last_name"    => 'testSurname',
    "display_name" => 'testDisplayName',
    "phone_number" => 'testPhoneNumber',
];

$response = $this->getUserService()->create($data, 'userId');

echo $response->getStatusCode(); //201
```

Replace a user

``` php
$data = [
    "first_name"   => 'testNameReplacement',
    "last_name"    => 'testSurnameReplacement',
    "display_name" => 'testDisplayNameReplacement',
    "phone_number" => 'testPhoneNumberReplacement',
];

$response = $this->getUserService()->replace($data, 'userId');

echo $response->getStatusCode(); //204
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

$response = $this->getUserService()->update($data, 'userId');

echo $response->getStatusCode(); //204
```

Get user details

``` php
$response = $this->getUserService()->get('userId');

echo $response->getStatusCode(); //200
echo $response->getContents(); //array
```

Delete a user

``` php
$response = $layer->getUserService()->delete('userId');

echo $response->getStatusCode(); //204
```

Create a badge for a user

``` php
$data = [
    "external_unread_count" => 15,
];

$response = $layer->getUserService()->createBadge($data, 'userId');

echo $response->getStatusCode(); //204
```

Get user`s badges

``` php
$response = $layer->getUserService()->getBadges('userId');

echo $response->getStatusCode(); //200
echo $response->getContents(); //array
```

### Accessing_user_data

Get all conversations by a user ID

``` php
$response = $layer->getUserDataService()->getConversations('userID');

echo $response->getStatusCode(); //200
echo $response->getContents(); //array
```
Update block list

``` php

$data = [
    0 => [
        'operation' => 'add',
        'property'  => 'blocks',
        'id'        => 'layer:///identities/blockMe1',
    ]
];

$response = $layer->getUserService()->updateBlockList($data, 'userId');

echo $response->getStatusCode(); //202
echo $response->getContents(); //array
```

Get block list

``` php

$response = $layer->getUserService()->getBlockList('userId');

echo $response->getStatusCode(); //200
echo $response->getContents(); //array
```

Send a message

``` php
$data = [
    'parts' => [
        [
            'body'      => 'Hello, World!',
            'mime_type' => 'text/plain'
        ],
    ],
];

$response = $layer->getUserDataService()->sendMessage($data, "user_id", "conversation_id");

echo $response->getStatusCode(); //201
```

Send a receipt

``` php

$response = $layer->getUserDataService()->sendReceipt('read', 'user_id', 'message_id');
echo $response->getStatusCode(); //204
```

Delete a message

``` php

$response = $layer->getUserDataService()->deleteMessage('user_id', 'message_id');
echo $response->getStatusCode(); //204
```

Additional information you can find [here][link-layer-documentation-user].

### Conversations

Create a conversation

``` php
$response = $layer->getConversationService()->create([
    'participants' => [
        "userId1",
        "userId2",
    ],
]);

echo $response->getStatusCode(); //201
```

Update a conversation

``` php
$response = $this->getConversationService()->update([
    [
        'operation' => 'set',
        'property'  => 'participants',
        'value'     =>  ["userId1", "userId2", "userId3"],
    ],
], 'conversationID');

echo $response->getStatusCode(); //204
```

Get conversation details

``` php
$response = $this->getConversationService()->get('conversationID');

echo $response->getStatusCode(); //200
echo $response->getContents(); //array
```

Get all conversations by user ID

``` php
$response = $layer->getConversationService()->all('userId1');

echo $response->getStatusCode(); //200
echo $response->getContents(); //array
```

Delete a conversation

``` php
$response = $layer->getConversationService()->delete('conversationID');

echo $response->getStatusCode(); //204
```

Additional information you can find [here][link-layer-documentation-conversation].

### Messages

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

$response = $layer->getMessageService()->create($data, 'conversationID');

echo $response->getStatusCode(); //201
```

Get all messages by a conversation ID

``` php
$response = $layer->getMessageService()->all('conversationID');

echo $response->getStatusCode(); //200
echo $response->getContents(); //array
```

Get a message

``` php
$response = $layer->getMessageService()->get('messageId', 'conversationID');

echo $response->getStatusCode(); //200
echo $response->getContents(); //array
```

Delete a message

``` php
$response = $layer->getMessageService()->delete('messageId', 'conversationID');

echo $response->getStatusCode(); //204

Additional information you can find [here][link-layer-documentation-message].
```

### Announcements

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

$response = $layer->getAnnouncementService()->create($data);

echo $response->getStatusCode(); //202
Additional information you can find [here][link-layer-documentation-announcement].
```

### Notifications

Create a notification

``` php
$data = [
    'recipients' => [
        "userId1",
        "userId2",
    ],
    'notification' => [
        'title' => 'New notification',
        'text'  => 'This is the alert text to include with the Push Notification.',
        'sound' => 'chime.aiff',
    ],
];

$response = $layer->getNotificationService()->create($data);

echo $response->getStatusCode(); //202
Additional information you can find [here][link-layer-documentation-notification].
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
[link-layer-documentation-user]: https://docs.layer.com/reference/server_api-1.1/users.out
[link-layer-documentation-conversation]: https://docs.layer.com/reference/server_api-1.1/conversations.out
[link-layer-documentation-message]: https://docs.layer.com/reference/server_api-1.1/messages.out
[link-layer-documentation-announcement]: https://docs.layer.com/reference/server_api-1.1/announcements.out
[link-layer-documentation-notification]: https://docs.layer.com/reference/server_api-1.1/push_notifications.out

[ico-version]: https://img.shields.io/packagist/v/aosmak/laravel-layer-sdk.svg
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg
[ico-downloads]: https://img.shields.io/packagist/dt/aosmak/laravel-layer-sdk.svg
[ico-stable]: https://poser.pugx.org/aosmak/laravel-layer-sdk/v/stable.svg
[ico-unstable]: https://poser.pugx.org/aosmak/laravel-layer-sdk/v/unstable.svg

[link-packagist]: https://packagist.org/packages/aosmak/laravel-layer-sdk
[link-travis]: https://travis-ci.org/:vendor/:package_name
[link-downloads]: https://packagist.org/packages/aosmak/laravel-layer-sdk
[link-contributors]: ../../contributors
