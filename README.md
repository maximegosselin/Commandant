# Commandant

[![Latest Version](https://img.shields.io/github/release/maximegosselin/commandant.svg)](https://github.com/maximegosselin/commandant/releases)
[![Build Status](https://img.shields.io/travis/maximegosselin/commandant.svg)](https://travis-ci.org/maximegosselin/commandant)
[![Software License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

*Commandant* is a lightweight and ultra-flexible Command Bus that won't get in your way.

It can dispatch commands of any kind and be customized with a middleware approach.


## System Requirements

PHP 7.0 or later.


## Install

Install using [Composer](https://getcomposer.org/):

```
$ composer require maximegosselin/commandant
```

*Commandant* is registered under the `MaximeGosselin\Commandant` namespace.


## Documentation

See [/docs](docs/USAGE.md) for complete documentation.

Create a command bus:
```php
$bus = new CommandBus();
```

Use simple string commands...
```php
$bus->registerHandler('login', function(string $command, array $arguments) {
    // Put some logic here...
});
 
$bus->dispatch('login', [
    'username' => 'john',
    'password' => 'secret'
]);
```

...or class commands
```php
$bus->registerHandler('\MyApp\LoginCommand', new \MyApp\LoginCommandHandler());
 
$command = new \MyApp\LoginCommand('john', 'secret');
 
$bus->dispatch($command);
```


## Tests

Run the following command from the project folder.
```
$ vendor/bin/phpunit
```


## License

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.
