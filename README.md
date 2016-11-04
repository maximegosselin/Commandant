# Commandant

[![Software License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

*Commandant* is an implementation of the Command design pattern using Command Bus.


## System Requirements

PHP 7.0 or later.


## Install

Install using [Composer](https://getcomposer.org/):

```
$ composer require maximegosselin/commandant
```

*Commandant* is registered under the `MaximeGosselin\Commandant` namespace.


## Documentation

TODO

```php
$commandBus = new TransactionalCommandBus(new CommandBus());

/* Object command */
$command = new MyCommand('foo', 123);
$commandBus->dispatch($foo);
 
/* String command */ 
$commandBus->dispatch('login', [
    'username' => 'john',
    'password' => 'secret'
]);
```

## Tests

Run the following command from the project folder.
```
$ vendor/bin/phpunit
```


## License

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.
