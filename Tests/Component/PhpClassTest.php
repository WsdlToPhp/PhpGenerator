<?php

namespace WsdlToPhp\PhpGenerator\Tests\Component;

use WsdlToPhp\PhpGenerator\Component\PhpClass as PhpClassComponent;
use WsdlToPhp\PhpGenerator\Element\PhpFunctionParameter as PhpFunctionParameterElement;
use WsdlToPhp\PhpGenerator\Element\PhpAnnotation as PhpAnnotationElement;
use WsdlToPhp\PhpGenerator\Element\PhpProperty as PhpPropertyElement;

class PhpClassTest extends AbstractComponent
{
    public function testSimpleToString()
    {
        $class = new PhpClassComponent('Foo', true, 'stdClass');

        $class
            ->addAnnotationBlock('@var string')
            ->addConstant('FOO', 'theValue')
            ->addAnnotationBlock('@var string')
            ->addConstant('BAR', 'theOtherValue')
            ->addAnnotationBlock(new PhpAnnotationElement('var', 'int'))
            ->addProperty('bar', 1)
            ->addAnnotationBlock(array(
                '- documentation: The ID of the contact that performed the action, if available. May be blank for anonymous activity.',
                new PhpAnnotationElement('var', 'bool'),
            ))
            ->addPropertyElement(new PhpPropertyElement('sample', true))
            ->addAnnotationBlock(new PhpAnnotationElement('var', 'string'))
            ->addPropertyElement(new PhpPropertyElement('noValue', PhpPropertyElement::NO_VALUE))
            ->addAnnotationBlock(array(
                new PhpAnnotationElement(PhpAnnotationElement::NO_NAME, 'This method is very useful'),
                new PhpAnnotationElement('date', '2012-03-01'),
                '@return mixed'
            ))
            ->addMethod('getMyValue', array(
                new PhpFunctionParameterElement('asString', true),
                'unusedParameter'
            ))
            ->addAnnotationBlock(array(
                new PhpAnnotationElement(PhpAnnotationElement::NO_NAME, 'This method is very useless'),
                new PhpAnnotationElement('date', '2012-03-01'),
                '@return void'
            ))
            ->addMethod('uselessMethod', array(
                new PhpFunctionParameterElement('uselessParameter', null),
                'unusedParameter'
            ));

        $this->assertSameContent(__FUNCTION__, $class);
    }
}
