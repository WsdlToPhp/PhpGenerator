<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Tests\Element;

use InvalidArgumentException;
use TypeError;
use WsdlToPhp\PhpGenerator\Element\PhpFunctionParameter;
use WsdlToPhp\PhpGenerator\Element\PhpInterface;
use WsdlToPhp\PhpGenerator\Element\PhpMethod;
use WsdlToPhp\PhpGenerator\Element\PhpVariable;
use WsdlToPhp\PhpGenerator\Tests\TestCase;

/**
 * @internal
 * @coversDefaultClass
 */
class PhpMethodTest extends TestCase
{
    public function testPublicGetPhpDeclaration()
    {
        $method = new PhpMethod('foo', [
            'bar',
            [
                'name' => 'demo',
                'value' => 1,
            ],
            [
                'name' => 'sample',
                'value' => null,
            ],
            new PhpFunctionParameter('deamon', true),
        ]);

        $this->assertSame('public function foo($bar, $demo = 1, $sample = null, $deamon = true)', $method->getPhpDeclaration());
    }

    public function testPublicGetPhpDeclarationWithReturnType()
    {
        $method = new PhpMethod('foo', [
            'bar',
            [
                'name' => 'demo',
                'value' => 1,
            ],
            [
                'name' => 'sample',
                'value' => null,
            ],
            new PhpFunctionParameter('deamon', true),
        ], 'float');

        $this->assertSame('public function foo($bar, $demo = 1, $sample = null, $deamon = true): float', $method->getPhpDeclaration());
    }

    public function testProtectedGetPhpDeclaration()
    {
        $method = new PhpMethod('foo', [
            'bar',
        ], null, PhpMethod::ACCESS_PROTECTED);

        $this->assertSame('protected function foo($bar)', $method->getPhpDeclaration());
    }

    public function testPrivateGetPhpDeclaration()
    {
        $method = new PhpMethod('foo', [
            'bar',
        ], null, PhpMethod::ACCESS_PRIVATE);

        $this->assertSame('private function foo($bar)', $method->getPhpDeclaration());
    }

    public function testPublicStaticGetPhpDeclaration()
    {
        $method = new PhpMethod('foo', [
            'bar',
        ], null, PhpMethod::ACCESS_PUBLIC, false, true);

        $this->assertSame('public static function foo($bar)', $method->getPhpDeclaration());
    }

    public function testProtectedStaticGetPhpDeclaration()
    {
        $method = new PhpMethod('foo', [
            'bar',
        ], null, PhpMethod::ACCESS_PROTECTED, false, true);

        $this->assertSame('protected static function foo($bar)', $method->getPhpDeclaration());
    }

    public function testPublicFinalGetPhpDeclaration()
    {
        $method = new PhpMethod('foo', [
            'bar',
        ], null, PhpMethod::ACCESS_PUBLIC, false, false, true);

        $this->assertSame('final public function foo($bar)', $method->getPhpDeclaration());
    }

    public function testAbstractPublicGetPhpDeclaration()
    {
        $method = new PhpMethod('foo', [
            'bar',
        ], null, PhpMethod::ACCESS_PUBLIC, true);

        $this->assertSame('abstract public function foo($bar);', $method->getPhpDeclaration());
    }

    public function testEmptyBodyPublicGetPhpDeclaration()
    {
        $method = new PhpMethod('foo', [
            'bar',
        ], null, PhpMethod::ACCESS_PUBLIC, false, false, false, false);

        $this->assertSame('public function foo($bar);', $method->getPhpDeclaration());
    }

    public function testAddChildWithException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Element of type "object:WsdlToPhp\PhpGenerator\Element\PhpInterface" is not authorized, please provide one of these types: string, WsdlToPhp\PhpGenerator\Element\PhpAnnotationBlock, WsdlToPhp\PhpGenerator\Element\PhpVariable');

        $method = new PhpMethod('Foo');

        $method->addChild(new PhpInterface('Bar'));
    }

    public function testGetLineBeforeChildren()
    {
        $method = new PhpMethod('Foo');
        $method->setHasBody(true);

        $line = $method->getLineBeforeChildren();

        $this->assertSame('', $line);
    }

    public function testGetLineAfterChildren()
    {
        $method = new PhpMethod('Foo');
        $method->setHasBody(true);

        $line = $method->getLineAfterChildren();

        $this->assertSame('', $line);
    }

    public function testAddChildString()
    {
        $method = new PhpMethod('Foo');

        $method->addChild("\n");

        $this->assertCount(1, $method->getChildren());
    }

    public function testAddChildVariable()
    {
        $method = new PhpMethod('foo', []);

        $method->addChild(new PhpVariable('bar'));

        $this->assertCount(1, $method->getChildren());
    }

    public function testPublicEmptyBodyToString()
    {
        $method = new PhpMethod('foo', [
            'bar',
            [
                'name' => 'demo',
                'value' => 1,
            ],
            [
                'name' => 'sample',
                'value' => null,
            ],
            new PhpFunctionParameter('deamon', true),
        ]);

        $this->assertSame("public function foo(\$bar, \$demo = 1, \$sample = null, \$deamon = true)\n{\n}", $method->toString());
    }

    public function testPublicEmptyBodyToStringWithReturnType()
    {
        $method = new PhpMethod('foo', [
            'bar',
            [
                'name' => 'demo',
                'value' => 1,
            ],
            [
                'name' => 'sample',
                'value' => null,
            ],
            new PhpFunctionParameter('deamon', true),
        ], 'App\\Entity');

        $this->assertSame("public function foo(\$bar, \$demo = 1, \$sample = null, \$deamon = true): App\\Entity\n{\n}", $method->toString());
    }

    public function testPublicEmptyBodyToStringWithNullableReturnType()
    {
        $method = new PhpMethod('foo', [
            'bar',
            [
                'name' => 'demo',
                'value' => 1,
            ],
            [
                'name' => 'sample',
                'value' => null,
            ],
            new PhpFunctionParameter('deamon', true),
        ], '?App\\Entity');

        $this->assertSame("public function foo(\$bar, \$demo = 1, \$sample = null, \$deamon = true): ?App\\Entity\n{\n}", $method->toString());
    }

    public function testPublicWithBodyToString()
    {
        $method = new PhpMethod('foo', [
            'bar',
            [
                'name' => 'demo',
                'value' => 1,
            ],
            [
                'name' => 'sample',
                'value' => null,
            ],
            new PhpFunctionParameter('deamon', true),
        ]);

        $method
            ->addChild(new PhpVariable('bar', 1))
            ->addChild('return $bar;')
        ;

        $this->assertSame("public function foo(\$bar, \$demo = 1, \$sample = null, \$deamon = true)\n{\n    \$bar = 1;\n    return \$bar;\n}", $method->toString());
    }

    public function testExceptionMessageOnName()
    {
        $this->expectException(TypeError::class);

        new PhpMethod(0);
    }
}
