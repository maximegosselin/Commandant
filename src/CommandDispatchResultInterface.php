<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant;

interface CommandDispatchResultInterface
{
    public function getValue();

    public function withValue($value = null):CommandDispatchResultInterface;
}
