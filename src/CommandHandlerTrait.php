<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant\Component;

use MaximeGosselin\Commandant\Api\CommandInterface;

trait CommandHandlerTrait
{
    public function handle(CommandInterface $command):bool
    {
        $parts = explode('\\', get_class($command));
        $method = 'handle' . end($parts);

        if (!method_exists($this, $method)) {
            return false;
        }

        $this->$method($command);

        return true;
    }
}
