<?php

namespace WsdlToPhp\PhpGenerator\Tests\Element;

use WsdlToPhp\PhpGenerator\Element\PhpAnnotationBlock;
use WsdlToPhp\PhpGenerator\Element\PhpConstant;
use WsdlToPhp\PhpGenerator\Element\PhpMethod;
use WsdlToPhp\PhpGenerator\Element\PhpProperty;
use WsdlToPhp\PhpGenerator\Element\PhpInterface;
use WsdlToPhp\PhpGenerator\Tests\TestCase;

class PhpInterfaceTest extends TestCase
{
    public function testSimpleInterface()
    {
        $interface = new PhpInterface('Foo');

        $this->assertSame('interface Foo', $interface->getPhpDeclaration());
    }

    public function testSimpleInterfaceNotAbstract()
    {
        $interface = new PhpInterface('Foo', true);

        $this->assertSame('interface Foo', $interface->getPhpDeclaration());
    }

    public function testSimpleInterfaceExtendsStringBar()
    {
        $interface = new PhpInterface('Foo', false, 'Bar');

        $this->assertSame('interface Foo', $interface->getPhpDeclaration());
    }

    public function testSimpleInterfaceExtendsBarImplementsStringDemo()
    {
        $interface = new PhpInterface('Foo', false, 'Bar', array(
            'Demo',
        ));

        $this->assertSame('interface Foo extends Demo', $interface->getPhpDeclaration());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddChildWithException()
    {
        $class = new PhpInterface('Foo');

        $class->addChild(new PhpProperty('Bar'));
    }

    public function testAddChildMethod()
    {
        $class = new PhpInterface('Foo');

        $class->addChild(new PhpMethod('Bar'));

        $this->assertCount(1, $class->getChildren());
    }

    public function testAddChildConstant()
    {
        $class = new PhpInterface('Foo');

        $class->addChild(new PhpConstant('Bar'));

        $this->assertCount(1, $class->getChildren());
    }

    public function testAddChildAnnotationBlock()
    {
        $class = new PhpInterface('Foo');

        $class->addChild(new PhpAnnotationBlock(array(
            'Bar',
        )));

        $this->assertCount(1, $class->getChildren());
    }

    public function testAddChildString()
    {
        $class = new PhpInterface('Foo');

        $class->addChild("\n");

        $this->assertCount(1, $class->getChildren());
    }
}
