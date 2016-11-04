<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant\Middleware;

class CommandDispatchResult implements CommandDispatchRequestInterface
{
    /**
     * @var mixed
     */
    private $command = null;

    /**
     * @var array
     */
    private $arguments = [];

    /**
     * @var callable
     */
    private $handler = null;

    protected function __construct($command, array $arguments = [], $handler = null)
    {
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

    /**
     * @return null|callable
     */
    public function getHandler()
    {
        return $this->handler;
    }

    public function withHandler(callable $handler = null):CommandDispatchRequestInterface
    {
        $clone = clone $this;
        $clone->handler = $handler;

        return $clone;
    }
}
