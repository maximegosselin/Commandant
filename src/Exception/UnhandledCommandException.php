<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant\Exception;

use RuntimeException;

class UnhandledCommandException extends RuntimeException
{
    public static function forCommand($command)
    {
        $name = is_object($command) ? get_class($command) : $command;
        $message = sprintf("No handler found for command '%s'.", $name);

        return new static($message);
    }
}
