<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant;

class CommandTypeValidator
{
    public static function validate($command):bool
    {
        return is_string($command) || is_object($command);
    }
}
