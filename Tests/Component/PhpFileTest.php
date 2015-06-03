<?php

namespace WsdlToPhp\PhpGenerator\Tests\Component;

use WsdlToPhp\PhpGenerator\Component\PhpClass as PhpClassComponent;
use WsdlToPhp\PhpGenerator\Component\PhpFile as PhpFileComponent;
use WsdlToPhp\PhpGenerator\Element\PhpFunctionParameter as PhpFunctionParameterElement;
use WsdlToPhp\PhpGenerator\Element\PhpAnnotation as PhpAnnotationElement;
use WsdlToPhp\PhpGenerator\Element\PhpProperty as PhpPropertyElement;

class PhpFileTest extends AbstractComponent
{
    public function testSimpleToString()
    {
        $file = new PhpFileComponent('Foo');
        $class = new PhpClassComponent('Foo', true, 'stdClass');

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
            ->addAnnotationBlock(new PhpAnnotationElement('var', 'int'))
            ->addProperty('bar', 1)
            ->addAnnotationBlock(new PhpAnnotationElement('var', 'bool'))
            ->addPropertyElement(new PhpPropertyElement('sample', true))
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
        $file->addClassComponent($class);

        $this->assertSameContent(__FUNCTION__, $file);
    }
}
