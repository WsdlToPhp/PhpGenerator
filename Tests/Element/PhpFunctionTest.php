<?php

namespace WsdlToPhp\PhpGenerator\Tests\Element;

use WsdlToPhp\PhpGenerator\Element\PhpFunctionParameter;
use WsdlToPhp\PhpGenerator\Element\PhpFunction;
use WsdlToPhp\PhpGenerator\Tests\TestCase;

class PhpFunctionTest extends TestCase
{
    public function testGetPhpDeclaration()
    {
        $function = new PhpFunction('foo', null, array(
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

        $this->assertSame('function foo($bar, $demo = 1, $sample = NULL, $deamon = true)', $function->getPhpDeclaration());
    }
}
