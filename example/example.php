<?php
use MaximeGosselin\Commandant\CommandBus;
use MaximeGosselin\Commandant\Core;
use MaximeGosselin\Commandant\Middleware\EchoMiddleware;
use MaximeGosselin\Commandant\Middleware\HandlerCallerMiddleware;
use MaximeGosselin\Commandant\Middleware\HandlerLocatorMiddleware;
use MaximeGosselin\Commandant\Middleware\PdoTransactionMiddleware;

require '../vendor/autoload.php';

$core = new Core();

$bus = new CommandBus($core);

$bus->addMiddleware(new PdoTransactionMiddleware(new PDO('sqlite::memory:')));
$bus->addMiddleware(new HandlerLocatorMiddleware());

$result = $bus->dispatch('login', [
    'username' => 'john',
    'password' => 'secret'
]);

print_r($result->getValue());
