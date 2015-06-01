<?php

namespace WsdlToPhp\PhpGenerator\Tests\Element;

use WsdlToPhp\PhpGenerator\Element\PhpClass;
use WsdlToPhp\PhpGenerator\Tests\TestCase;

class PhpClassTest extends TestCase
{
    public function testSimpleClass()
    {
        $class = new PhpClass('Foo');

        $this->assertSame('class Foo', $class->getPhpDeclaration());
    }

    public function testAbstractClass()
    {
        $class = new PhpClass('Foo', true);

        $this->assertSame('abstract class Foo', $class->getPhpDeclaration());
    }

    public function testSimpleClassExtendsStringBar()
    {
        $class = new PhpClass('Foo', false, 'Bar');

        $this->assertSame('class Foo extends Bar', $class->getPhpDeclaration());
    }

    public function testAbstractClassExtendsStringBar()
    {
        $class = new PhpClass('Foo', true, 'Bar');

        $this->assertSame('abstract class Foo extends Bar', $class->getPhpDeclaration());
    }

    public function testSimpleClassExtendsStringBarImplementsStringDemo()
    {
        $class = new PhpClass('Foo', false, 'Bar', array(
            'Demo',
        ));

        $this->assertSame('class Foo extends Bar implements Demo', $class->getPhpDeclaration());
    }

    public function testSimpleClassExtendsStringBarImplementsArrayStringDemoSample()
    {
        $class = new PhpClass('Foo', false, 'Bar', array(
            'Demo',
            'Sample',
        ));

        $this->assertSame('class Foo extends Bar implements Demo, Sample', $class->getPhpDeclaration());
    }

    public function testAbstractClassExtendsStringBarImplementsStringDemo()
    {
        $class = new PhpClass('Foo', true, 'Bar', array(
            'Demo',
        ));

        $this->assertSame('abstract class Foo extends Bar implements Demo', $class->getPhpDeclaration());
    }

    public function testAbstractClassExtendsStringBarImplementsArrayStringDemoSample()
    {
        $class = new PhpClass('Foo', true, 'Bar', array(
            'Demo',
            'Sample',
        ));

        $this->assertSame('abstract class Foo extends Bar implements Demo, Sample', $class->getPhpDeclaration());
    }

    public function testSimpleClassExtendsStringBarImplementsPhpClassDemo()
    {
        $class = new PhpClass('Foo', false, 'Bar', array(
            new PhpClass('Demo'),
        ));

        $this->assertSame('class Foo extends Bar implements Demo', $class->getPhpDeclaration());
    }

    public function testSimpleClassExtendsStringBarImplementsArrayPhpClassDemoSample()
    {
        $class = new PhpClass('Foo', false, 'Bar', array(
            new PhpClass('Demo'),
            new PhpClass('Sample'),
        ));

        $this->assertSame('class Foo extends Bar implements Demo, Sample', $class->getPhpDeclaration());
    }

    public function testAbstractClassExtendsStringBarImplementsPhpClassDemo()
    {
        $class = new PhpClass('Foo', true, 'Bar', array(
            new PhpClass('Demo'),
        ));

        $this->assertSame('abstract class Foo extends Bar implements Demo', $class->getPhpDeclaration());
    }

    public function testAbstractClassExtendsStringBarImplementsArrayPhpClassDemoSample()
    {
        $class = new PhpClass('Foo', true, 'Bar', array(
            new PhpClass('Demo'),
            new PhpClass('Sample'),
        ));

        $this->assertSame('abstract class Foo extends Bar implements Demo, Sample', $class->getPhpDeclaration());
    }
}
