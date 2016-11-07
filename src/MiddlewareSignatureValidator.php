<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant;

use ReflectionFunction;

class MiddlewareSignatureValidator
{
    public static function validate(callable $middleware):bool
    {
        $reflection = new ReflectionFunction($middleware);

        return self::hasValidParameters($reflection) && self::hasValidReturnType($reflection);
    }

    private static function hasValidParameters(ReflectionFunction $reflection):bool
    {
        $params = $reflection->getParameters();

        if (count($params) != 3) {
            return false;
        }
        if (!$params[0]->getType() || !$params[1]->getType() || !$params[2]->getType()) {
            return false;
        }
        if ((string)$params[0]->getType() != CommandDispatchRequestInterface::class) {
            return false;
        }
        if ((string)$params[1]->getType() != CommandDispatchResultInterface::class) {
            return false;
        }
        if ((string)$params[2]->getType() != 'callable') {
            return false;
        }

        return true;
    }

    private static function hasValidReturnType(ReflectionFunction $reflection):bool
    {
        $returnType = $reflection->getReturnType();
        if (!$returnType) {
            return false;
        }

        return $returnType->__toString() == CommandDispatchResultInterface::class;
    }
}
