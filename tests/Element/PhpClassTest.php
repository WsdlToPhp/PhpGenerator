<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Tests\Element;

use InvalidArgumentException;
use TypeError;
use WsdlToPhp\PhpGenerator\Element\PhpAnnotationBlock;
use WsdlToPhp\PhpGenerator\Element\PhpClass;
use WsdlToPhp\PhpGenerator\Element\PhpConstant;
use WsdlToPhp\PhpGenerator\Element\PhpInterface;
use WsdlToPhp\PhpGenerator\Element\PhpMethod;
use WsdlToPhp\PhpGenerator\Element\PhpProperty;
use WsdlToPhp\PhpGenerator\Element\PhpVariable;
use WsdlToPhp\PhpGenerator\Tests\TestCase;

/**
 * @internal
 * @coversDefaultClass
 */
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
        $class = new PhpClass('Foo', false, 'Bar', [
            'Demo',
        ]);

        $this->assertSame('class Foo extends Bar implements Demo', $class->getPhpDeclaration());
    }

    public function testGetPhpDeclarationSimpleClassExtendsStringBarImplementsArrayStringDemoSample()
    {
        $class = new PhpClass('Foo', false, 'Bar', [
            'Demo',
            'Sample',
        ]);

        $this->assertSame('class Foo extends Bar implements Demo, Sample', $class->getPhpDeclaration());
    }

    public function testGetPhpDeclarationAbstractClassExtendsStringBarImplementsStringDemo()
    {
        $class = new PhpClass('Foo', true, 'Bar', [
            'Demo',
        ]);

        $this->assertSame('abstract class Foo extends Bar implements Demo', $class->getPhpDeclaration());
    }

    public function testGetPhpDeclarationAbstractClassExtendsStringBarImplementsArrayStringDemoSample()
    {
        $class = new PhpClass('Foo', true, 'Bar', [
            'Demo',
            'Sample',
        ]);

        $this->assertSame('abstract class Foo extends Bar implements Demo, Sample', $class->getPhpDeclaration());
    }

    public function testGetPhpDeclarationSimpleClassExtendsStringBarImplementsPhpClassDemo()
    {
        $class = new PhpClass('Foo', false, 'Bar', [
            new PhpClass('Demo'),
        ]);

        $this->assertSame('class Foo extends Bar implements Demo', $class->getPhpDeclaration());
    }

    public function testGetPhpDeclarationSimpleClassExtendsStringBarImplementsArrayPhpClassDemoSample()
    {
        $class = new PhpClass('Foo', false, 'Bar', [
            new PhpClass('Demo'),
            new PhpClass('Sample'),
        ]);

        $this->assertSame('class Foo extends Bar implements Demo, Sample', $class->getPhpDeclaration());
    }

    public function testGetPhpDeclarationAbstractClassExtendsStringBarImplementsPhpClassDemo()
    {
        $class = new PhpClass('Foo', true, 'Bar', [
            new PhpClass('Demo'),
        ]);

        $this->assertSame('abstract class Foo extends Bar implements Demo', $class->getPhpDeclaration());
    }

    public function testGetPhpDeclarationAbstractClassExtendsStringBarImplementsArrayPhpClassDemoSample()
    {
        $class = new PhpClass('Foo', true, 'Bar', [
            new PhpClass('Demo'),
            new PhpClass('Sample'),
        ]);

        $this->assertSame('abstract class Foo extends Bar implements Demo, Sample', $class->getPhpDeclaration());
    }

    public function testAddChildWithException()
    {
        $this->expectException(InvalidArgumentException::class);

        $class = new PhpClass('Foo');

        $class->addChild(new PhpInterface('Bar'));
    }

    public function testSetAbstract()
    {
        $this->expectException(TypeError::class);

        $class = new PhpClass('Foo');

        $class->setAbstract(1);
    }

    public function testSetExtendsWithException()
    {
        $this->expectException(InvalidArgumentException::class);

        $class = new PhpClass('Foo');

        $class->setExtends(0);
    }

    public function testSetExtends()
    {
        $class = new PhpClass('Foo');

        $class->setExtends($extends = 'Partagé');

        $this->assertSame($extends, $class->getExtends());
    }

    public function testSetInterfacesWithException()
    {
        $this->expectException(InvalidArgumentException::class);

        $class = new PhpClass('Foo');

        $class->setInterfaces($interfaces = [
            0,
        ]);
    }

    public function testSetInterfaces()
    {
        $class = new PhpClass('Foo');

        $class->setInterfaces($interfaces = [
            'Partagé',
        ]);

        $this->assertSame($interfaces, $class->getInterfaces());
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

        $class->addChild(new PhpAnnotationBlock([
            'Bar',
        ]));

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

    public function testSimpleClassEmptyBodyToString()
    {
        $class = new PhpClass('Foo');

        $this->assertSame("class Foo\n{\n}", $class->toString());
    }

    public function testSimpleClassEmptyBodyToStringMatchesStringCaasting()
    {
        $class = new PhpClass('Foo');

        $this->assertSame((string) $class, $class->toString());
    }

    public function testSimpleClassEmptyPublicMethodToString()
    {
        $class = new PhpClass('Foo');

        $class->addChild(new PhpMethod('bar'));

        $this->assertSame("class Foo\n{\n    public function bar()\n    {\n    }\n}", $class->toString());
    }

    public function testSimpleClassEmptyProtectedMethodToString()
    {
        $class = new PhpClass('Foo');

        $class->addChild(new PhpMethod('bar', [], null, PhpMethod::ACCESS_PROTECTED));

        $this->assertSame("class Foo\n{\n    protected function bar()\n    {\n    }\n}", $class->toString());
    }

    public function testSimpleClassEmptyPrivateMethodToString()
    {
        $class = new PhpClass('Foo');

        $class->addChild(new PhpMethod('bar', [], null, PhpMethod::ACCESS_PRIVATE));

        $this->assertSame("class Foo\n{\n    private function bar()\n    {\n    }\n}", $class->toString());
    }

    public function testSimpleClassPublicMethodToString()
    {
        $class = new PhpClass('Foo');

        $method = new PhpMethod('bar', [
            'bar',
            'foo',
            'sample',
        ], null, PhpMethod::ACCESS_PRIVATE);
        $method->addChild(new PhpVariable('foo', 1));
        $class->addChild($method);

        $this->assertSame("class Foo\n{\n    private function bar(\$bar, \$foo, \$sample)\n    {\n        \$foo = 1;\n    }\n}", $class->toString());
    }

    public function testExtendsFromNamespace()
    {
        $class = new PhpClass('Foo', false, '\\DOMDocument');

        $this->assertSame("class Foo extends \\DOMDocument\n{\n}", $class->toString());
    }

    public function testExceptionMessageOnName()
    {
        $this->expectException(TypeError::class);

        new PhpClass(0);
    }
}
