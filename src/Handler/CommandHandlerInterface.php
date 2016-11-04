<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant\Api;

interface CommandHandlerInterface
{
    public function handle(CommandInterface $command):bool;
}
