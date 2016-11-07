<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant;

use MaximeGosselin\Commandant\Exception\InvalidCommandTypeException;
use MaximeGosselin\Commandant\Exception\InvalidMiddlewareException;
use MaximeGosselin\Rainbow\MiddlewareStack;
use MaximeGosselin\Rainbow\MiddlewareStackInterface;

class CommandBus implements CommandBusInterface
{
    /**
     * @var MiddlewareStackInterface
     */
    private $middlewares;

    /**
     * @var CommandHandlerInvoker
     */
    private $invoker;

    public function __construct()
    {
        $this->invoker = new CommandHandlerInvoker();
        $this->middlewares = new MiddlewareStack([
            $this->invoker,
            'invoke'
        ]);
    }

    public function dispatch($command, array $arguments = []):CommandDispatchResultInterface
    {
        if (!CommandTypeValidator::validate($command)) {
            throw InvalidCommandTypeException::forCommand($command);
        }

        $request = new CommandDispatchRequest($command, $arguments);
        $result = new CommandDispatchResult(null);

        return $this->middlewares->call($request, $result);
    }

    public function registerHandler(string $identifier, callable $handler):CommandBusInterface
    {
        $this->invoker->registerHandler($identifier, $handler);

        return $this;
    }

    public function addMiddleware(callable $middleware):CommandBusInterface
    {
        if (!MiddlewareSignatureValidator::validate($middleware)) {
            throw new InvalidMiddlewareException();
        }
        $this->middlewares->push($middleware);

        return $this;
    }
}
