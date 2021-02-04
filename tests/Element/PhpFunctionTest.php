<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Tests\Element;

use InvalidArgumentException;
use TypeError;
use WsdlToPhp\PhpGenerator\Element\PhpFunction;
use WsdlToPhp\PhpGenerator\Element\PhpFunctionParameter;
use WsdlToPhp\PhpGenerator\Element\PhpProperty;
use WsdlToPhp\PhpGenerator\Element\PhpVariable;
use WsdlToPhp\PhpGenerator\Tests\TestCase;

/**
 * @internal
 * @coversDefaultClass
 */
class PhpFunctionTest extends TestCase
{
    public function testGetPhpDeclaration()
    {
        $function = new PhpFunction('foo', [
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

        $this->assertSame('function foo($bar, $demo = 1, $sample = null, $deamon = true)', $function->getPhpDeclaration());
    }

    public function testGetPhpDeclarationWithReturnType()
    {
        $function = new PhpFunction('foo', [
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
        ], 'void');

        $this->assertSame('function foo($bar, $demo = 1, $sample = null, $deamon = true): void', $function->getPhpDeclaration());
    }

    public function testAddChild()
    {
        $this->expectException(InvalidArgumentException::class);

        $function = new PhpFunction('foo', []);

        $function->addChild(new PhpProperty('Bar'));
    }

    public function testSetParameters()
    {
        $this->expectException(InvalidArgumentException::class);

        $function = new PhpFunction('foo', []);

        $function->setParameters([
            new PhpFunction('bar'),
        ]);
    }

    public function testSetName()
    {
        $function = new PhpFunction('foo', []);

        $function->setName($name = 'Partagé');

        $this->assertSame($name, $function->getName());
    }

    public function testAddChildVariable()
    {
        $function = new PhpFunction('foo', []);

        $function->addChild(new PhpVariable('bar'));

        $this->assertCount(1, $function->getChildren());
    }

    public function testSetReturnType()
    {
        $function = new PhpFunction('foo', []);

        $function->setReturnType($returnType = 'int');

        $this->assertSame($returnType, $function->getReturnType());
    }

    public function testAddChildString()
    {
        $function = new PhpFunction('foo', []);

        $function->addChild('bar');

        $this->assertCount(1, $function->getChildren());
    }

    public function testToStringEmptyBody()
    {
        $function = new PhpFunction('foo', [
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

        $this->assertSame("function foo(\$bar, \$demo = 1, \$sample = null, \$deamon = true)\n{\n}", $function->toString());
    }

    public function testToStringWithBody()
    {
        $function = new PhpFunction('foo', [
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

        $function
            ->addChild(new PhpVariable('bar', 1))
            ->addChild('return $bar;')
        ;

        $this->assertSame("function foo(\$bar, \$demo = 1, \$sample = null, \$deamon = true)\n{\n    \$bar = 1;\n    return \$bar;\n}", $function->toString());
    }

    public function testToStringWithBodyWithReturnType()
    {
        $function = new PhpFunction('foo', [
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
        ], 'int');

        $function
            ->addChild(new PhpVariable('bar', 1))
            ->addChild('return $bar;')
        ;

        $this->assertSame("function foo(\$bar, \$demo = 1, \$sample = null, \$deamon = true): int\n{\n    \$bar = 1;\n    return \$bar;\n}", $function->toString());
    }

    public function testToStringWithBodyWithNullableReturnType()
    {
        $function = new PhpFunction('foo', [
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
        ], '?int');

        $function
            ->addChild(new PhpVariable('bar', 1))
            ->addChild('return $bar;')
        ;

        $this->assertSame("function foo(\$bar, \$demo = 1, \$sample = null, \$deamon = true): ?int\n{\n    \$bar = 1;\n    return \$bar;\n}", $function->toString());
    }

    public function testExceptionMessageOnName()
    {
        $this->expectException(TypeError::class);

        new PhpFunction(0);
    }
}
