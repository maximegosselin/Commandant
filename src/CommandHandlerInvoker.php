<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant;

use MaximeGosselin\Commandant\Exception\CommandIdentifierNotUniqueException;
use MaximeGosselin\Commandant\Exception\UnhandledCommandException;

class CommandHandlerInvoker
{
    /**
     * @var array
     */
    private $handlers;

    /**
     * @param CommandDispatchRequestInterface $request
     * @param CommandDispatchResultInterface $result
     * @return CommandDispatchResultInterface
     * @throws UnhandledCommandException If no handler is registered for command.
     */
    public function invoke(
        CommandDispatchRequestInterface $request,
        CommandDispatchResultInterface $result
    ):CommandDispatchResultInterface {
    

        $command = $request->getCommand();
        $isObjectCommand = is_object($command);
        $isStringCommand = is_string($command);
        $identifier = $isObjectCommand ? get_class($command) : $command;
        $arguments = $request->getArguments();

        if (!isset($this->handlers[$identifier])) {
            throw UnhandledCommandException::forCommand($command);
        }
        $handler = $this->handlers[$identifier];

        if ($isObjectCommand) {
            $result = call_user_func_array($handler, [
                $command
            ]);
        }
        if ($isStringCommand) {
            $result = call_user_func_array($handler, [
                $command,
                $arguments
            ]);
        }

        return new CommandDispatchResult($result);
    }

    /**
     * @param string $identifier
     * @param callable $handler
     * @throws CommandIdentifierNotUniqueException
     */
    public function registerHandler(string $identifier, callable $handler)
    {
        if ($this->hasRegisteredHandler($identifier)) {
            throw CommandIdentifierNotUniqueException::forIdentifier($identifier);
        }
        $this->handlers[$identifier] = $handler;
    }

    /**
     * @param string $identifier
     * @return bool
     */
    public function hasRegisteredHandler(string $identifier):bool
    {
        return isset($this->handlers[$identifier]);
    }
}
