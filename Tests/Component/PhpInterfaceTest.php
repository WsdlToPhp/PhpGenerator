<?php

namespace WsdlToPhp\PhpGenerator\Tests\Component;

use WsdlToPhp\PhpGenerator\Component\PhpInterface as PhpInterfaceComponent;
use WsdlToPhp\PhpGenerator\Element\PhpFunctionParameter as PhpFunctionParameterElement;
use WsdlToPhp\PhpGenerator\Element\PhpAnnotation as PhpAnnotationElement;
use WsdlToPhp\PhpGenerator\Element\PhpProperty as PhpPropertyElement;
use WsdlToPhp\PhpGenerator\Element\PhpMethod;

class PhpInterfaceTest extends AbstractComponent
{
    public function testSimpleToString()
    {
        $interface = new PhpInterfaceComponent('Foo', true, null, array(
            'stdClass',
        ));

        $interface
            ->addAnnotationBlock('@var string')
            ->addConstant('FOO', 'theValue')
            ->addAnnotationBlock('@var string')
            ->addConstant('BAR', 'theOtherValue')
            ->addAnnotationBlock(new PhpAnnotationElement('var', 'int'))
            ->addProperty('bar', 1)
            ->addAnnotationBlock(new PhpAnnotationElement('var', 'bool'))
            ->addPropertyElement(new PhpPropertyElement('sample', true))
            ->addAnnotationBlock(array(
                new PhpAnnotationElement(PhpAnnotationElement::NO_NAME, 'This method is very useful'),
                new PhpAnnotationElement('date', '2012-03-01'),
                '@return mixed'
            ))
            ->addMethodElement(new PhpMethod('getMyValue', array(
                new PhpFunctionParameterElement('asString', true),
                'unusedParameter'
            )))
            ->addAnnotationBlock(array(
                new PhpAnnotationElement(PhpAnnotationElement::NO_NAME, 'This method is very useless'),
                new PhpAnnotationElement('date', '2012-03-01'),
                '@return void'
            ))
            ->addMethod('uselessMethod', array(
                new PhpFunctionParameterElement('uselessParameter', null),
                'unusedParameter'
            ));

        $this->assertSameContent(__FUNCTION__, $interface);
    }
}
