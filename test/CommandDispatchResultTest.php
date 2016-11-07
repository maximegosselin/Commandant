<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant\Test;

use MaximeGosselin\Commandant\CommandDispatchResult;

class CommandDispatchResultTest extends TestCase
{
    public function testImmutability()
    {
        $result = new CommandDispatchResult(1);
        $newResult = $result->withValue(1);

        $this->assertNotSame($result, $newResult);
    }
}
