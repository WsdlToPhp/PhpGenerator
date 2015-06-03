<?php

namespace WsdlToPhp\PhpGenerator\Tests\Component;

use WsdlToPhp\PhpGenerator\Element\PhpFunctionParameter;
use WsdlToPhp\PhpGenerator\Element\PhpAnnotation;
use WsdlToPhp\PhpGenerator\Tests\TestCase;
use WsdlToPhp\PhpGenerator\Element\PhpProperty;
use WsdlToPhp\PhpGenerator\Component\PhpClass;

class PhpClassTest extends AbstractComponent
{
    public function testSimpleToString()
    {
        $class = new PhpClass('Foo', true, 'stdClass');

        $class
            ->setNamespace('My\\Testing\\NamespaceName')
            ->addUse('My\\Testing\\ParentNamespace\\Model')
            ->addUse('My\\Testing\\ParentNamespace\\Repository')
            ->addUse('My\\Testing\\ParentNamespace\\Generator')
            ->addUse('My\\Testing\\ParentNamespace\\Foo', 'FooType')
            ->addAnnotationBlock('@var string')
            ->addConstant('FOO', 'theValue')
            ->addAnnotationBlock('@var string')
            ->addConstant('BAR', 'theOtherValue')
            ->addAnnotationBlock(new PhpAnnotation('var', 'int'))
            ->addProperty('bar', 1)
            ->addAnnotationBlock(new PhpAnnotation('var', 'bool'))
            ->addPropertyElement(new PhpProperty('sample', true))
            ->addAnnotationBlock(array(
                new PhpAnnotation(PhpAnnotation::NO_NAME, 'This method is very useful'),
                new PhpAnnotation('date', '2012-03-01'),
                '@return mixed'
            ))
            ->addMethod('getMyValue', array(
                new PhpFunctionParameter('asString', true),
                'unusedParameter'
            ))
            ->addAnnotationBlock(array(
                new PhpAnnotation(PhpAnnotation::NO_NAME, 'This method is very useless'),
                new PhpAnnotation('date', '2012-03-01'),
                '@return void'
            ))
            ->addMethod('uselessMethod', array(
                new PhpFunctionParameter('uselessParameter', null),
                'unusedParameter'
            ));

        $this->assertSameContent(__FUNCTION__, $class);
    }
}
