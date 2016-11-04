<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant\Middleware;

class CoreMiddleware
{
    public function __invoke(CommandDispatchRequestInterface $request):CommandDispatchResultInterface
    {
        echo "CORE\n";

        return new CommandDispatchResult(date('Y-m-d H:i:s'));
    }
}
