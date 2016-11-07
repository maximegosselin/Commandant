<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant;

use MaximeGosselin\Commandant\Exception\InvalidCommandTypeException;

interface CommandDispatchRequestInterface
{
    /**
     * @return string|object
     */
    public function getCommand();

    /**
     * @param string|object $command
     * @return CommandDispatchRequestInterface
     * @throws InvalidCommandTypeException If $command type is not string or object.
     */
    public function withCommand($command):CommandDispatchRequestInterface;

    public function getArguments():array;

    public function withArguments(array $arguments):CommandDispatchRequestInterface;
}
