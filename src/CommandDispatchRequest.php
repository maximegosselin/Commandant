<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant;

use MaximeGosselin\Commandant\Exception\InvalidCommandTypeException;

class CommandDispatchRequest implements CommandDispatchRequestInterface
{
    /**
     * @var string|object
     */
    private $command;

    /**
     * @var array
     */
    private $arguments;

    public function __construct($command, array $arguments = [], $handler = null)
    {
        $this->assertCommandType($command);
        $this->command = $command;
        $this->arguments = $arguments;
        $this->handler = $handler;
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function withCommand($command):CommandDispatchRequestInterface
    {
        $this->assertCommandType($command);
        $clone = clone $this;
        $clone->command = $command;

        return $clone;
    }

    public function getArguments():array
    {
        return $this->arguments;
    }

    public function withArguments(array $arguments):CommandDispatchRequestInterface
    {
        $clone = clone $this;
        $clone->arguments = $arguments;

        return $clone;
    }

    private function assertCommandType($command)
    {
        if (!CommandTypeValidator::validate($command)) {
            throw InvalidCommandTypeException::forCommand($command);
        }
    }
}
