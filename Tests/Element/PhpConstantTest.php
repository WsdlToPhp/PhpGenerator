<?php

use WsdlToPhp\PhpGenerator\Element\PhpClass;

use WsdlToPhp\PhpGenerator\Element\PhpConstant;

use WsdlToPhp\PhpGenerator\Tests\TestCase;

class PhpConstantTest extends TestCase
{
    public function testGetPhpDeclarationNullValue()
    {
        $variable = new PhpConstant('foo');

        $this->assertSame('define(\'foo\', NULL);', $variable->getPhpDeclaration());
    }

    public function testGetPhpDeclarationTrueValue()
    {
        $variable = new PhpConstant('foo', true);

        $this->assertSame('define(\'foo\', true);', $variable->getPhpDeclaration());
    }

    public function testGetPhpDeclarationFalseValue()
    {
        $variable = new PhpConstant('foo', false);

        $this->assertSame('define(\'foo\', false);', $variable->getPhpDeclaration());
    }

    public function testGetPhpDeclarationStringOneValue()
    {
        $variable = new PhpConstant('foo', '1');

        $this->assertSame('define(\'foo\', \'1\');', $variable->getPhpDeclaration());
    }

    public function testGetPhpDeclarationNumberOneValue()
    {
        $variable = new PhpConstant('foo', 1);

        $this->assertSame('define(\'foo\', 1);', $variable->getPhpDeclaration());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testExceptionForNonScalerValue()
    {
        new PhpConstant('Foo', array());
    }

    public function testGetPhpDeclarationNullValueForClass()
    {
        $variable = new PhpConstant('foo', null, new PhpClass('bar'));

        $this->assertSame('const FOO = NULL;', $variable->getPhpDeclaration());
    }

    public function testGetPhpDeclarationTrueValueForClass()
    {
        $variable = new PhpConstant('foo', true, new PhpClass('Bar'));

        $this->assertSame('const FOO = true;', $variable->getPhpDeclaration());
    }

    public function testGetPhpDeclarationFalseValueForClass()
    {
        $variable = new PhpConstant('foo', false, new PhpClass('Bar'));

        $this->assertSame('const FOO = false;', $variable->getPhpDeclaration());
    }

    public function testGetPhpDeclarationStringOneValueForClass()
    {
        $variable = new PhpConstant('foo', '1', new PhpClass('Bar'));

        $this->assertSame('const FOO = \'1\';', $variable->getPhpDeclaration());
    }

    public function testGetPhpDeclarationNumberOneValueForClass()
    {
        $variable = new PhpConstant('foo', 1, new PhpClass('Bar'));

        $this->assertSame('const FOO = 1;', $variable->getPhpDeclaration());
    }
}
