<?php

namespace WsdlToPhp\PhpGenerator\Tests\Element;

use WsdlToPhp\PhpGenerator\Element\PhpProperty;
use WsdlToPhp\PhpGenerator\Element\PhpAnnotationBlock;
use WsdlToPhp\PhpGenerator\Element\PhpConstant;
use WsdlToPhp\PhpGenerator\Element\PhpMethod;
use WsdlToPhp\PhpGenerator\Element\PhpInterface;
use WsdlToPhp\PhpGenerator\Element\PhpClass;
use WsdlToPhp\PhpGenerator\Tests\TestCase;

class PhpClassTest extends TestCase
{
    public function testGetPhpDeclarationSimpleClass()
    {
        $class = new PhpClass('Foo');

        $this->assertSame('class Foo', $class->getPhpDeclaration());
    }

    public function testGetPhpDeclarationAbstractClass()
    {
        $class = new PhpClass('Foo', true);

        $this->assertSame('abstract class Foo', $class->getPhpDeclaration());
    }

    public function testGetPhpDeclarationSimpleClassExtendsStringBar()
    {
        $class = new PhpClass('Foo', false, 'Bar');

        $this->assertSame('class Foo extends Bar', $class->getPhpDeclaration());
    }

    public function testGetPhpDeclarationAbstractClassExtendsStringBar()
    {
        $class = new PhpClass('Foo', true, 'Bar');

        $this->assertSame('abstract class Foo extends Bar', $class->getPhpDeclaration());
    }

    public function testGetPhpDeclarationSimpleClassExtendsStringBarImplementsStringDemo()
    {
        $class = new PhpClass('Foo', false, 'Bar', array(
            'Demo',
        ));

        $this->assertSame('class Foo extends Bar implements Demo', $class->getPhpDeclaration());
    }

    public function testGetPhpDeclarationSimpleClassExtendsStringBarImplementsArrayStringDemoSample()
    {
        $class = new PhpClass('Foo', false, 'Bar', array(
            'Demo',
            'Sample',
        ));

        $this->assertSame('class Foo extends Bar implements Demo, Sample', $class->getPhpDeclaration());
    }

    public function testGetPhpDeclarationAbstractClassExtendsStringBarImplementsStringDemo()
    {
        $class = new PhpClass('Foo', true, 'Bar', array(
            'Demo',
        ));

        $this->assertSame('abstract class Foo extends Bar implements Demo', $class->getPhpDeclaration());
    }

    public function testGetPhpDeclarationAbstractClassExtendsStringBarImplementsArrayStringDemoSample()
    {
        $class = new PhpClass('Foo', true, 'Bar', array(
            'Demo',
            'Sample',
        ));

        $this->assertSame('abstract class Foo extends Bar implements Demo, Sample', $class->getPhpDeclaration());
    }

    public function testGetPhpDeclarationSimpleClassExtendsStringBarImplementsPhpClassDemo()
    {
        $class = new PhpClass('Foo', false, 'Bar', array(
            new PhpClass('Demo'),
        ));

        $this->assertSame('class Foo extends Bar implements Demo', $class->getPhpDeclaration());
    }

    public function testGetPhpDeclarationSimpleClassExtendsStringBarImplementsArrayPhpClassDemoSample()
    {
        $class = new PhpClass('Foo', false, 'Bar', array(
            new PhpClass('Demo'),
            new PhpClass('Sample'),
        ));

        $this->assertSame('class Foo extends Bar implements Demo, Sample', $class->getPhpDeclaration());
    }

    public function testGetPhpDeclarationAbstractClassExtendsStringBarImplementsPhpClassDemo()
    {
        $class = new PhpClass('Foo', true, 'Bar', array(
            new PhpClass('Demo'),
        ));

        $this->assertSame('abstract class Foo extends Bar implements Demo', $class->getPhpDeclaration());
    }

    public function testGetPhpDeclarationAbstractClassExtendsStringBarImplementsArrayPhpClassDemoSample()
    {
        $class = new PhpClass('Foo', true, 'Bar', array(
            new PhpClass('Demo'),
            new PhpClass('Sample'),
        ));

        $this->assertSame('abstract class Foo extends Bar implements Demo, Sample', $class->getPhpDeclaration());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddChildWithException()
    {
        $class = new PhpClass('Foo');

        $class->addChild(new PhpInterface('Bar'));
    }

    public function testAddChildMethod()
    {
        $class = new PhpClass('Foo');

        $class->addChild(new PhpMethod('Bar'));

        $this->assertCount(1, $class->getChildren());
    }

    public function testAddChildConstant()
    {
        $class = new PhpClass('Foo');

        $class->addChild(new PhpConstant('Bar'));

        $this->assertCount(1, $class->getChildren());
    }

    public function testAddChildAnnotationBlock()
    {
        $class = new PhpClass('Foo');

        $class->addChild(new PhpAnnotationBlock(array(
            'Bar',
        )));

        $this->assertCount(1, $class->getChildren());
    }

    public function testAddChildProperty()
    {
        $class = new PhpClass('Foo');

        $class->addChild(new PhpProperty('Bar'));

        $this->assertCount(1, $class->getChildren());
    }

    public function testAddChildString()
    {
        $class = new PhpClass('Foo');

        $class->addChild("\n");

        $this->assertCount(1, $class->getChildren());
    }
}