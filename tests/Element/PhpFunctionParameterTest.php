<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Tests\Element;

use InvalidArgumentException;
use TypeError;
use WsdlToPhp\PhpGenerator\Element\PhpFunctionParameter;
use WsdlToPhp\PhpGenerator\Element\PhpMethod;
use WsdlToPhp\PhpGenerator\Tests\TestCase;

/**
 * @internal
 * @coversDefaultClass
 */
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

        $this->assertInstanceOf(PhpFunctionParameter::class, $functionParameter->setType('string'));
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

    public function testFloatValueForDeclaration()
    {
        $initialSerializePrecision = ini_get('serialize_precision');
        ini_set('serialize_precision', '2');

        $functionParameter = new PhpFunctionParameter('foo', 1.101, 'float');

        $this->assertSame('float $foo = 1.101', $functionParameter->toString());

        ini_set('serialize_precision', $initialSerializePrecision);
    }

    public function testSetTypeForDeclaration()
    {
        $functionParameter = new PhpFunctionParameter('foo', true, 'bool');

        $this->assertSame('bool $foo = true', $functionParameter->toString());
    }

    public function testToStringEmptyArrayValue()
    {
        $functionParameter = new PhpFunctionParameter('foo', [], 'array');

        $this->assertSame('array $foo = []', $functionParameter->toString());
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
