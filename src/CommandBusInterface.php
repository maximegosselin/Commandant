<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant;

use MaximeGosselin\Commandant\Exception\InvalidCommandHandlerException;
use MaximeGosselin\Commandant\Exception\InvalidCommandTypeException;
use MaximeGosselin\Commandant\Exception\InvalidMiddlewareException;

interface CommandBusInterface
{
    /**
     * @param string|object $command The command as a string or an object.
     * @param array $arguments Optional arguments for a string command.
     * @return CommandDispatchResultInterface
     * @throws InvalidCommandTypeException If $command type is not string or object.
     */
    public function dispatch($command, array $arguments = []):CommandDispatchResultInterface;

    /**
     * @param string $identifier The command unique identifier.
     *     It can be the string command or the command fully-qualified class name.
     * @param callable $handler A callable with signature ($command, array $arguments = [])
     * @return CommandBusInterface self
     * @throws InvalidCommandHandlerException If the callable signature is not valid.
     */
    public function registerHandler(string $identifier, callable $handler):CommandBusInterface;

    /**
     * @param callable $middleware A callable with signature (CommandDispatchRequestInterface $request,
     *     CommandDispatchResultInterface $result, callable $next):CommandDispatchResultInterface
     * @return CommandBusInterface self
     * @throws InvalidMiddlewareException If the callable signature is not valid.
     */
    public function addMiddleware(callable $middleware):CommandBusInterface;
}
