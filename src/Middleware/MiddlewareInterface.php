<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant\Middleware;

interface MiddlewareInterface
{
    public function __invoke($command, array $arguments, callable $next);
}
