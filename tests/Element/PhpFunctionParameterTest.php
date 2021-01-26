<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Tests\Element;

use InvalidArgumentException;
use TypeError;
use WsdlToPhp\PhpGenerator\Element\PhpFunctionParameter;
use WsdlToPhp\PhpGenerator\Tests\TestCase;
use WsdlToPhp\PhpGenerator\Element\PhpMethod;

class PhpFunctionParameterTest extends TestCase
{
    public function testSetType()
    {
        $this->expectException(InvalidArgumentException::class);

        $functionParameter = new PhpFunctionParameter('foo', true);

        $functionParameter->setType(new PhpMethod('Bar'));
    }

    public function testSetTypeOk()
    {
        $functionParameter = new PhpFunctionParameter('foo', true);

        $this->assertInstanceOf('\\WsdlTophp\\PhpGenerator\\Element\\PhpFunctionParameter', $functionParameter->setType('string'));
    }

    public function testTypeIsValid()
    {
        $this->assertTrue(PhpFunctionParameter::typeIsValid('string'));
    }

    public function testNullableTypeIsValid()
    {
        $this->assertTrue(PhpFunctionParameter::typeIsValid('?string'));
    }

    public function testTypeIsValidAccentuated()
    {
        $this->assertTrue(PhpFunctionParameter::typeIsValid('Partagé'));
    }

    public function testSetTypeForDeclaration()
    {
        $functionParameter = new PhpFunctionParameter('foo', true, 'bool');

        $this->assertSame('bool $foo = true', $functionParameter->toString());
    }

    public function testToStringEmptyArrayValue()
    {
        $functionParameter = new PhpFunctionParameter('foo', [], 'array');

        $this->assertSame('array $foo = array()', $functionParameter->toString());
    }

    public function testToStringWithNamespace()
    {
        $functionParameter = new PhpFunctionParameter('foo', null, 'My\Name\Space');

        $this->assertSame('My\Name\Space $foo = null', $functionParameter->toString());
    }

    public function testToStringWithNamespacedNullableParameter()
    {
        $functionParameter = new PhpFunctionParameter('foo', null, '?My\Name\Space');

        $this->assertSame('?My\Name\Space $foo = null', $functionParameter->toString());
    }

    public function testExceptionMessageOnName()
    {
        $this->expectException(TypeError::class);

        new PhpFunctionParameter(0);
    }
}
