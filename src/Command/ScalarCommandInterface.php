<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant\Component;

interface ScalarCommandInterface
{
    public function getArguments():array;
}
