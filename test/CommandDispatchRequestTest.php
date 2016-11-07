<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant\Test;

use MaximeGosselin\Commandant\CommandDispatchRequest;

class CommandDispatchRequestTest extends TestCase
{
    public function testImmutability()
    {
        $request = new CommandDispatchRequest('foo', [1]);
        $newRequest1 = $request->withCommand('bar');
        $newRequest2 = $request->withArguments([1]);

        $this->assertNotSame($request, $newRequest1);
        $this->assertNotSame($request, $newRequest2);
    }

    /**
     * @expectedException \MaximeGosselin\Commandant\Exception\InvalidCommandTypeException
     */
    public function testInvalidCommandTypeWithConstructor()
    {
        new CommandDispatchRequest(123);
    }

    /**
     * @expectedException \MaximeGosselin\Commandant\Exception\InvalidCommandTypeException
     */
    public function testInvalidCommandTypeWithSetter()
    {
        (new CommandDispatchRequest('foo'))->withCommand(123);
    }
}
