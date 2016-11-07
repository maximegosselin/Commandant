<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant\Exception;

use InvalidArgumentException;

class CommandIdentifierNotUniqueException extends InvalidArgumentException
{
    public static function forIdentifier(string $identifier)
    {
        $message = sprintf("A command handler is already registered with identifier '%s'.", $identifier);

        return new static($message);
    }
}
