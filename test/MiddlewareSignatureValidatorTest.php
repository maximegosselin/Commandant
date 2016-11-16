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
        $mw = function($request, $result, $next) {
        };
        $this->assertTrue(MiddlewareSignatureValidator::validate($mw));

        $mw = function(CommandDispatchRequestInterface $request, $result, $next) {
        };
        $this->assertTrue(MiddlewareSignatureValidator::validate($mw));

        $mw = function($request, CommandDispatchResultInterface $result, $next) {
        };
        $this->assertTrue(MiddlewareSignatureValidator::validate($mw));

        $mw = function($request, $result, callable $next) {
        };
        $this->assertTrue(MiddlewareSignatureValidator::validate($mw));

        $mw = function($request, $result, $next):CommandDispatchResultInterface {
        };
        $this->assertTrue(MiddlewareSignatureValidator::validate($mw));

        $mw = function(
            CommandDispatchRequestInterface $request, CommandDispatchResultInterface $result, callable $next
        ):CommandDispatchResultInterface {
        };
        $this->assertTrue(MiddlewareSignatureValidator::validate($mw));
    }

    public function testInvalidParameters()
    {
        $mw = function() {
        };
        $this->assertFalse(MiddlewareSignatureValidator::validate($mw));

        $mw = function($a) {
        };
        $this->assertFalse(MiddlewareSignatureValidator::validate($mw));

        $mw = function($a, $b) {
        };
        $this->assertFalse(MiddlewareSignatureValidator::validate($mw));

        $mw = function($a, $b, $c, $d) {
        };
        $this->assertFalse(MiddlewareSignatureValidator::validate($mw));

        $mw = function(string $request, $result, $next) {
        };
        $this->assertFalse(MiddlewareSignatureValidator::validate($mw));

        $mw = function($request, string $result, $next) {
        };
        $this->assertFalse(MiddlewareSignatureValidator::validate($mw));

        $mw = function($request, $result, string $next) {
        };
        $this->assertFalse(MiddlewareSignatureValidator::validate($mw));

        $mw = function($request, $result, $next):string {
        };
        $this->assertFalse(MiddlewareSignatureValidator::validate($mw));
    }

    public function testInvalidReturnType()
    {
        $mw = function(
            CommandDispatchRequestInterface $request, CommandDispatchResultInterface $result, callable $next
        ):string {
        };
        $this->assertFalse(MiddlewareSignatureValidator::validate($mw));
    }
}
