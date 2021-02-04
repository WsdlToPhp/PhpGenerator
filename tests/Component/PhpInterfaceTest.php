<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Tests\Component;

use WsdlToPhp\PhpGenerator\Component\PhpInterface as PhpInterfaceComponent;
use WsdlToPhp\PhpGenerator\Element\PhpAnnotation as PhpAnnotationElement;
use WsdlToPhp\PhpGenerator\Element\PhpFunctionParameter as PhpFunctionParameterElement;
use WsdlToPhp\PhpGenerator\Element\PhpMethod;
use WsdlToPhp\PhpGenerator\Element\PhpProperty as PhpPropertyElement;

/**
 * @internal
 * @coversDefaultClass
 */
class PhpInterfaceTest extends AbstractComponent
{
    public function testSimpleToString()
    {
        $interface = new PhpInterfaceComponent('Foo', true, null, [
            'stdClass',
        ]);

        $interface
            ->addAnnotationBlock('@var string')
            ->addConstant('FOO', 'theValue')
            ->addAnnotationBlock('@var string')
            ->addConstant('BAR', 'theOtherValue')
            ->addAnnotationBlock(new PhpAnnotationElement('var', 'int'))
            ->addProperty('bar', 1)
            ->addAnnotationBlock(new PhpAnnotationElement('var', 'bool'))
            ->addPropertyElement(new PhpPropertyElement('sample', true))
            ->addAnnotationBlock([
                new PhpAnnotationElement(PhpAnnotationElement::NO_NAME, 'This method is very useful'),
                new PhpAnnotationElement('date', '2012-03-01'),
                '@return mixed',
            ])
            ->addMethodElement(new PhpMethod('getMyValue', [
                new PhpFunctionParameterElement('asString', true),
                'unusedParameter',
            ]))
            ->addAnnotationBlock([
                new PhpAnnotationElement(PhpAnnotationElement::NO_NAME, 'This method is very useless'),
                new PhpAnnotationElement('date', '2012-03-01'),
                '@return void',
            ])
            ->addMethod('uselessMethod', [
                new PhpFunctionParameterElement('uselessParameter', null),
                'unusedParameter',
            ])
        ;

        $this->assertSameContent(__FUNCTION__, $interface);
    }

    public function testSimpleToStringWithReturnType()
    {
        $interface = new PhpInterfaceComponent('Foo', true, null, [
            'stdClass',
        ]);

        $interface
            ->addAnnotationBlock('@var string')
            ->addConstant('FOO', 'theValue')
            ->addAnnotationBlock('@var string')
            ->addConstant('BAR', 'theOtherValue')
            ->addAnnotationBlock(new PhpAnnotationElement('var', 'int'))
            ->addProperty('bar', 1)
            ->addAnnotationBlock(new PhpAnnotationElement('var', 'bool'))
            ->addPropertyElement(new PhpPropertyElement('sample', true))
            ->addAnnotationBlock([
                new PhpAnnotationElement(PhpAnnotationElement::NO_NAME, 'This method is very useful'),
                new PhpAnnotationElement('date', '2012-03-01'),
                '@return mixed',
            ])
            ->addMethodElement(new PhpMethod('getMyValue', [
                new PhpFunctionParameterElement('asString', true),
                'unusedParameter',
            ]))
            ->addAnnotationBlock([
                new PhpAnnotationElement(PhpAnnotationElement::NO_NAME, 'This method is very useless'),
                new PhpAnnotationElement('date', '2012-03-01'),
                '@return void',
            ])
            ->addMethod('uselessMethod', [
                new PhpFunctionParameterElement('uselessParameter', null),
                'unusedParameter',
            ], 'void')
        ;

        $this->assertSameContent(__FUNCTION__, $interface);
    }
}
