<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant\Test;

use MaximeGosselin\Commandant\CommandBus;
use MaximeGosselin\Commandant\CommandBusInterface;
use MaximeGosselin\Commandant\CommandDispatchRequestInterface;
use MaximeGosselin\Commandant\CommandDispatchResultInterface;
use stdClass;

class CommandBusTest extends TestCase
{
    /**
     * @var CommandBusInterface
     */
    private $commandBus;

    public function setUp()
    {
        $this->commandBus = new CommandBus();
    }

    public function testAddValidMiddleware()
    {
        $mw = function (
            CommandDispatchRequestInterface $request,
            CommandDispatchResultInterface $result,
            callable $next
        ):CommandDispatchResultInterface {
        };

        $this->commandBus->addMiddleware($mw);
    }

    /**
     * @expectedException \MaximeGosselin\Commandant\Exception\InvalidMiddlewareException
     */
    public function testAddInvalidMiddleware1ThrowsException()
    {
        $mw = function () {
        };

        $this->commandBus->addMiddleware($mw);
    }

    /**
     * @expectedException \MaximeGosselin\Commandant\Exception\InvalidMiddlewareException
     */
    public function testAddInvalidMiddleware2ThrowsException()
    {
        $mw = function (
            CommandDispatchRequestInterface $request,
            CommandDispatchResultInterface $result,
            callable $next
        ) {
        };

        $this->commandBus->addMiddleware($mw);
    }

    /**
     * @expectedException \MaximeGosselin\Commandant\Exception\InvalidMiddlewareException
     */
    public function testAddInvalidMiddleware3ThrowsException()
    {
        $mw = function ():CommandDispatchResultInterface {
        };

        $this->commandBus->addMiddleware($mw);
    }

    public function testDispatchStringCommandToRegisteredHandlerWithMiddleware()
    {
        $in = null;
        $out = null;

        $mw = function (
            CommandDispatchRequestInterface $request,
            CommandDispatchResultInterface $result,
            callable $next
        ) use (
            &$in,
            &$out
):CommandDispatchResultInterface {
            $in = 1;
            $result = $next($request, $result);
            $out = 1;

            return $result->withValue(strtoupper($result->getValue()));
        };

        $handler = function (string $command, array $arguments = []) {
            return implode(',', $arguments);
        };

        $this->commandBus->addMiddleware($mw);
        $this->commandBus->registerHandler('foo', $handler);

        $result = $this->commandBus->dispatch('foo', [
            'bar' => 'baz',
            'qux' => 'quux'
        ]);

        $this->assertEquals($in, 1);
        $this->assertEquals($out, 1);
        $this->assertSame($result->getValue(), 'BAZ,QUUX');
    }

    /**
     * @expectedException \MaximeGosselin\Commandant\Exception\UnhandledCommandException
     */
    public function testDispatchUnhandledStringCommandThrowsException()
    {
        $this->commandBus->dispatch('foo');
    }

    public function testDispatchObjectCommandToRegisteredHandler()
    {
        $command = $this->getMockBuilder(stdClass::class)->setMockClassName('MyCommand')->getMock();

        $handler = function (\MyCommand $command) {
            return 123;
        };

        $this->commandBus->registerHandler('MyCommand', $handler);

        $result = $this->commandBus->dispatch($command);
        $this->assertSame($result->getValue(), 123);
    }

    /**
     * @expectedException \MaximeGosselin\Commandant\Exception\UnhandledCommandException
     */
    public function testDispatchUnhandledObjectCommandThrowsException()
    {
        $command = $this->getMockBuilder(stdClass::class)->setMockClassName('MyCommand')->getMock();
        $this->commandBus->dispatch($command);
    }

    /**
     * @expectedException \MaximeGosselin\Commandant\Exception\InvalidCommandTypeException
     */
    public function testInvalidCommandTypeThrowsException()
    {
        $this->commandBus->dispatch(123);
    }

    /**
     * @expectedException \MaximeGosselin\Commandant\Exception\CommandIdentifierNotUniqueException
     */
    public function testRegisterWithDuplicateCommandIdentifierThrowsException()
    {
        $handler = function (string $command, array $arguments = []) {
            return implode(',', $arguments);
        };
        $this->commandBus->registerHandler('foo', $handler);
        $this->commandBus->registerHandler('foo', $handler);
    }
}
