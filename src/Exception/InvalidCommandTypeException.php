<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant\Exception;

use InvalidArgumentException;

class InvalidCommandTypeException extends InvalidArgumentException
{
    public static function forCommand($command)
    {
        $message = sprintf("Command type must be string or object, got '%s'.", gettype($command));

        return new static($message);
    }
}
