<?php

namespace WsdlToPhp\PhpGenerator\Tests\Element;

use WsdlToPhp\PhpGenerator\Element\PhpFunctionParameter;
use WsdlToPhp\PhpGenerator\Element\PhpMethod;
use WsdlToPhp\PhpGenerator\Tests\TestCase;

class PhpMethodTest extends TestCase
{
    public function testPublicGetPhpDeclaration()
    {
        $method = new PhpMethod('foo', PhpMethod::ACCESS_PUBLIC, array(
            'bar',
            array(
                'name' => 'demo',
                'value' => 1,
            ),
            array(
                'name' => 'sample',
                'value' => null,
            ),
            new PhpFunctionParameter('deamon', true),
        ));

        $this->assertSame('public function foo($bar, $demo = 1, $sample = NULL, $deamon = true)', $method->getPhpDeclaration());
    }

    public function testProtectedGetPhpDeclaration()
    {
        $method = new PhpMethod('foo', PhpMethod::ACCESS_PROTECTED, array(
            'bar',
        ));

        $this->assertSame('protected function foo($bar)', $method->getPhpDeclaration());
    }

    public function testPrivateGetPhpDeclaration()
    {
        $method = new PhpMethod('foo', PhpMethod::ACCESS_PRIVATE, array(
            'bar',
        ));

        $this->assertSame('private function foo($bar)', $method->getPhpDeclaration());
    }

    public function testPublicStaticGetPhpDeclaration()
    {
        $method = new PhpMethod('foo', PhpMethod::ACCESS_PUBLIC, array(
            'bar',
        ), false, true);

        $this->assertSame('public static function foo($bar)', $method->getPhpDeclaration());
    }

    public function testProtectedStaticGetPhpDeclaration()
    {
        $method = new PhpMethod('foo', PhpMethod::ACCESS_PROTECTED, array(
            'bar',
        ), false, true);

        $this->assertSame('protected static function foo($bar)', $method->getPhpDeclaration());
    }

    public function testPublicFinalGetPhpDeclaration()
    {
        $method = new PhpMethod('foo', PhpMethod::ACCESS_PUBLIC, array(
            'bar',
        ), false, false, true);

        $this->assertSame('final public function foo($bar)', $method->getPhpDeclaration());
    }

    public function testAbstractPublicGetPhpDeclaration()
    {
        $method = new PhpMethod('foo', PhpMethod::ACCESS_PUBLIC, array(
            'bar',
        ), true);

        $this->assertSame('abstract public function foo($bar);', $method->getPhpDeclaration());
    }
}
