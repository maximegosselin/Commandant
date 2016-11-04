<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant\Middleware;

use SplQueue;

class MiddlewarePipe implements MiddlewarePipeInterface
{
    /**
     * @var SplQueue
     */
    private $queue;

    public function __construct()
    {
        $this->queue = new SplQueue();
    }

    public function pipe(callable $middleware):MiddlewarePipeInterface
    {
        $this->queue->enqueue($middleware);

        return $this;
    }

    public function dispatch($command, array $arguments = []) {

    }
}
