<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant;

use ReflectionFunction;
use ReflectionMethod;

class MiddlewareSignatureValidator
{
    public static function validate(callable $middleware):bool
    {
        $function = is_array($middleware) ? new ReflectionMethod($middleware[0], $middleware[1]) : new ReflectionFunction($middleware);

        return self::hasValidParameters($function) && self::hasValidReturnType($function);
    }

    private static function hasValidParameters(ReflectionFunction $function):bool
    {
        $params = $function->getParameters();

        if (count($params) != 3) {
            return false;
        }
        if ($params[0]->getType() && (string)$params[0]->getType() != CommandDispatchRequestInterface::class) {
            return false;
        }
        if ($params[1]->getType() && (string)$params[1]->getType() != CommandDispatchResultInterface::class) {
            return false;
        }
        if ($params[2]->getType() && (string)$params[2]->getType() != 'callable') {
            return false;
        }

        return true;
    }

    private static function hasValidReturnType(ReflectionFunction $function):bool
    {
        $returnType = $function->getReturnType();
        if ($returnType && $returnType->__toString() != CommandDispatchResultInterface::class) {
            return false;
        }

        return true;
    }
}
