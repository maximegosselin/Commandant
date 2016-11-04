<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant\Middleware;

use SplQueue;

class MiddlewarePipe implements MiddlewarePipeInterface
{
    /**
     * @var SplQueue
     */
    private $middlewares;

    public function __construct()
    {
        $this->middlewares = new SplQueue();
    }

    public function pipe(callable $middleware):MiddlewarePipeInterface
    {
        $this->middlewares->enqueue($middleware);

        return $this;
    }

    public function dispatch($command, array $arguments = [])
    {
    }
}
