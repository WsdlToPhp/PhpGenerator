<?php

namespace WsdlToPhp\PhpGenerator\Tests\Element;

use WsdlToPhp\PhpGenerator\Element\PhpVariable;
use WsdlToPhp\PhpGenerator\Element\PhpClass;
use WsdlToPhp\PhpGenerator\Element\PhpConstant;
use WsdlToPhp\PhpGenerator\Tests\TestCase;

class PhpConstantTest extends TestCase
{
    public function testGetPhpDeclarationNullValue()
    {
        $constant = new PhpConstant('foo');

        $this->assertSame('define(\'foo\', null);', $constant->getPhpDeclaration());
    }

    public function testGetPhpDeclarationTrueValue()
    {
        $constant = new PhpConstant('foo', true);

        $this->assertSame('define(\'foo\', true);', $constant->getPhpDeclaration());
    }

    public function testGetPhpDeclarationFalseValue()
    {
        $constant = new PhpConstant('foo', false);

        $this->assertSame('define(\'foo\', false);', $constant->getPhpDeclaration());
    }

    public function testGetPhpDeclarationStringOneValue()
    {
        $constant = new PhpConstant('foo', '1');

        $this->assertSame('define(\'foo\', \'1\');', $constant->getPhpDeclaration());
    }

    public function testGetPhpDeclarationNumberOneValue()
    {
        $constant = new PhpConstant('foo', 1);

        $this->assertSame('define(\'foo\', 1);', $constant->getPhpDeclaration());
    }

    public function testGetPhpDeclarationParenthesisValue()
    {
        $constant = new PhpConstant('foo', 'NCSA Common (Apache default)');

        $this->assertSame('define(\'foo\', \'NCSA Common (Apache default)\');', $constant->getPhpDeclaration());
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
        $constant = new PhpConstant('foo', null, new PhpClass('bar'));

        $this->assertSame('const FOO = null;', $constant->getPhpDeclaration());
    }

    public function testGetPhpDeclarationParenthesisValueForClass()
    {
        $constant = new PhpConstant('foo', 'NCSA Common (Apache default)', new PhpClass('bar'));

        $this->assertSame('const FOO = \'NCSA Common (Apache default)\';', $constant->getPhpDeclaration());
    }

    public function testGetPhpDeclarationTrueValueForClass()
    {
        $constant = new PhpConstant('foo', true, new PhpClass('Bar'));

        $this->assertSame('const FOO = true;', $constant->getPhpDeclaration());
    }

    public function testGetPhpDeclarationFalseValueForClass()
    {
        $constant = new PhpConstant('foo', false, new PhpClass('Bar'));

        $this->assertSame('const FOO = false;', $constant->getPhpDeclaration());
    }

    public function testGetPhpDeclarationStringOneValueForClass()
    {
        $constant = new PhpConstant('foo', '1', new PhpClass('Bar'));

        $this->assertSame('const FOO = \'1\';', $constant->getPhpDeclaration());
    }

    public function testGetPhpDeclarationNumberOneValueForClass()
    {
        $constant = new PhpConstant('foo', 1, new PhpClass('Bar'));

        $this->assertSame('const FOO = 1;', $constant->getPhpDeclaration());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddChild()
    {
        $constant = new PhpVariable('Foo', 'bar');

        $constant->addChild(new PhpVariable('Bar', 'foo'));
    }

    public function testToStringNullValue()
    {
        $constant = new PhpConstant('foo');

        $this->assertSame('define(\'foo\', null);', $constant->toString());
    }

    public function testToStringNullValueForClass()
    {
        $constant = new PhpConstant('foo', null, new PhpClass('bar'));

        $this->assertSame('const FOO = null;', $constant->toString());
    }

    public function testGetChildrenTypes()
    {
        $constant = new PhpConstant('foo', null, new PhpClass('bar'));

        $this->assertSame(array(), $constant->getChildrenTypes());
    }

    public function testExceptionMessageOnName()
    {
        try {
            new PhpConstant(0);
        } catch (\InvalidArgumentException $e) {
            $this->assertSame('Name "0" is invalid when instantiating PhpConstant object', $e->getMessage());
        }
    }

    public function testExceptionMessageOnValue()
    {
        try {
            new PhpConstant('Foo', new \stdClass());
        } catch (\InvalidArgumentException $e) {
            $this->assertSame('Value of type "object" is not a valid scalar value for PhpConstant object', $e->getMessage());
        }
    }
}
