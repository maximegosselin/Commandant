<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant\Middleware;

interface MiddlewarePipeInterface
{
    /**
     * @param callable|MiddlewareInterface $middleware
     * @return MiddlewarePipeInterface
     */
    public function pipe(callable $middleware):MiddlewarePipeInterface;

    public function dispatch($command, array $arguments = []);
}
