<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant\Api;

interface CommandHandlerLocatorInterface
{
    public function resolve($command):CommandHandlerInterface;
}
