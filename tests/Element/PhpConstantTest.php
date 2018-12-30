<?php

declare(strict_types=1);

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
        new PhpConstant('Foo', []);
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

        $this->assertSame([], $constant->getChildrenTypes());
    }

    /**
     * @expectedException \TypeError
     */
    public function testExceptionMessageOnName()
    {
        new PhpConstant(0);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Value of type "object" is not a valid scalar value for PhpConstant object
     */
    public function testExceptionMessageOnValue()
    {
        new PhpConstant('Foo', new \stdClass());
    }
}
