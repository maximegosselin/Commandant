<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant\Middleware;

interface CommandDispatchResponseInterface
{
    public static function createWith($result = null):CommandDispatchResponseInterface;

    public function getResult();

    public function withResutlt($result = null):CommandDispatchResponseInterface;
}
