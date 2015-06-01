<?php

namespace WsdlToPhp\PhpGenerator\Tests\Element;

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
}
