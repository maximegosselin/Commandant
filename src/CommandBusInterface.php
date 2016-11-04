<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant\Api;

interface CommandBusInterface
{
    /**
     * @param string|object $command A string command or an object.
     * @param array $arguments Optional arguments for the string command.
     * @return bool If the command was handled.
     */
    public function dispatch($command, array $arguments = []):bool;
}
