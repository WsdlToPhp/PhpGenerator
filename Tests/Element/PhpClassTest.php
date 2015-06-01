<?php

namespace WsdlToPhp\PhpGenerator\Tests\Element;

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
}
