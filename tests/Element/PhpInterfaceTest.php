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
        $interface = new PhpInterface('Foo');

        $interface->addChild(new PhpProperty('Bar'));
    }

    public function testAddChildMethod()
    {
        $interface = new PhpInterface('Foo');

        $interface->addChild(new PhpMethod('Bar'));

        $this->assertCount(1, $interface->getChildren());
    }

    public function testAddChildConstant()
    {
        $interface = new PhpInterface('Foo');

        $interface->addChild(new PhpConstant('Bar'));

        $this->assertCount(1, $interface->getChildren());
    }

    public function testAddChildAnnotationBlock()
    {
        $interface = new PhpInterface('Foo');

        $interface->addChild(new PhpAnnotationBlock(array(
            'Bar',
        )));

        $this->assertCount(1, $interface->getChildren());
    }

    public function testAddChildString()
    {
        $interface = new PhpInterface('Foo');

        $interface->addChild("\n");

        $this->assertCount(1, $interface->getChildren());
    }

    public function testSimpleIntefaceEmptyPublicMethodToString()
    {
        $interface = new PhpInterface('Foo');

        $interface->addChild(new PhpMethod('bar'));

        $this->assertSame("interface Foo\n{\n    public function bar();\n}", $interface->toString());
    }

    public function testExceptionMessageOnName()
    {
        try {
            new PhpInterface(0);
        } catch (\InvalidArgumentException $e) {
            $this->assertSame('Name "0" is invalid when instantiating PhpInterface object', $e->getMessage());
        }
    }
}
