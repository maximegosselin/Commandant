<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant;

/**
 * Middlewares SHOULD implement this interface.
 */
interface MiddlewareInterface
{
    public function __invoke(
        CommandDispatchRequestInterface $request,
        CommandDispatchResultInterface $result,
        callable $next
    ):CommandDispatchResultInterface;
}
