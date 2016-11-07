<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant;

class CommandDispatchResult implements CommandDispatchResultInterface
{
    /**
     * @var mixed
     */
    private $value;

    public function __construct($value = null)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function withValue($value = null):CommandDispatchResultInterface
    {
        $clone = clone $this;
        $clone->value = $value;

        return $clone;
    }
}
