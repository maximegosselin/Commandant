<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant\Test;

use MaximeGosselin\Commandant\CommandDispatchRequestInterface;
use MaximeGosselin\Commandant\CommandDispatchResultInterface;
use MaximeGosselin\Commandant\MiddlewareSignatureValidator;

class MiddlewareSignatureValidatorTest extends TestCase
{
    public function testValidSignature()
    {
        $mw = function (
            CommandDispatchRequestInterface $request,
            CommandDispatchResultInterface $result,
            callable $next
        ):CommandDispatchResultInterface {
        };

        $this->assertTrue(MiddlewareSignatureValidator::validate($mw));
    }

    public function testInvalidParameters()
    {
        $mw = function (
            $request,
            CommandDispatchResultInterface $result,
            callable $next
        ):CommandDispatchResultInterface {
        };
        $this->assertFalse(MiddlewareSignatureValidator::validate($mw));
        $mw = function (
            string $request,
            CommandDispatchResultInterface $result,
            callable $next
        ):CommandDispatchResultInterface {
        };
        $this->assertFalse(MiddlewareSignatureValidator::validate($mw));

        $mw = function (
            CommandDispatchRequestInterface $request,
            $result,
            callable $next
        ):CommandDispatchResultInterface {
        };
        $this->assertFalse(MiddlewareSignatureValidator::validate($mw));
        $mw = function (
            CommandDispatchRequestInterface $request,
            string $result,
            callable $next
        ):CommandDispatchResultInterface {
        };
        $this->assertFalse(MiddlewareSignatureValidator::validate($mw));

        $mw = function (
            CommandDispatchRequestInterface $request,
            CommandDispatchResultInterface $result,
            $next
        ):CommandDispatchResultInterface {
        };
        $this->assertFalse(MiddlewareSignatureValidator::validate($mw));
        $mw = function (
            CommandDispatchRequestInterface $request,
            CommandDispatchResultInterface $result,
            string $next
        ):CommandDispatchResultInterface {
        };
        $this->assertFalse(MiddlewareSignatureValidator::validate($mw));
    }

    public function testInvalidReturnType()
    {
        $mw = function (
            CommandDispatchRequestInterface $request,
            CommandDispatchResultInterface $result,
            callable $next
        ) {
        };
        $this->assertFalse(MiddlewareSignatureValidator::validate($mw));

        $mw = function (
            CommandDispatchRequestInterface $request,
            CommandDispatchResultInterface $result,
            callable $next
        ):string {
        };
        $this->assertFalse(MiddlewareSignatureValidator::validate($mw));
    }
}
