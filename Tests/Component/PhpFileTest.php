<?php

namespace WsdlToPhp\PhpGenerator\Tests\Component;

use WsdlToPhp\PhpGenerator\Component\PhpClass as PhpClassComponent;
use WsdlToPhp\PhpGenerator\Component\PhpFile as PhpFileComponent;
use WsdlToPhp\PhpGenerator\Component\PhpInterface as PhpInterfaceComponent;
use WsdlToPhp\PhpGenerator\Element\PhpFunctionParameter as PhpFunctionParameterElement;
use WsdlToPhp\PhpGenerator\Element\PhpAnnotation as PhpAnnotationElement;
use WsdlToPhp\PhpGenerator\Element\PhpProperty as PhpPropertyElement;

class PhpFileTest extends AbstractComponent
{
    public function testSimpleClassToString()
    {
        $file = new PhpFileComponent('Foo');
        $class = new PhpClassComponent('Foo', true, 'stdClass');

        $class
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

        $file
            ->setNamespace('My\\Testing\\NamespaceName')
            ->addUse('My\\Testing\\ParentNamespace\\Model')
            ->addUse('My\\Testing\\ParentNamespace\\Repository')
            ->addUse('My\\Testing\\ParentNamespace\\Generator')
            ->addUse('My\\Testing\\ParentNamespace\\Foo', 'FooType', true)
            ->addClassComponent($class);

        $this->assertSameContent(__FUNCTION__, $file);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetMainElementWithException()
    {
        $file = new PhpFileComponent('Foo');

        $file->setMainElement(new PhpFunctionParameterElement('bar'));
    }

    public function testAddVariableToString()
    {
        $file = new PhpFileComponent('Foo');

        $file->addVariable('foo', 0);

        $this->assertSame("<?php\n\$foo = 0;\n", $file->toString());
    }

    public function testAddFunctionToString()
    {
        $file = new PhpFileComponent('Foo');

        $file->addFunction('name', array(
            'bar',
        ));

        $this->assertSame("<?php\nfunction name(\$bar)\n{\n}\n", $file->toString());
    }
    public function testSimpleInterfaceToString()
    {
        $file = new PhpFileComponent('Foo');
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

        $file
            ->setNamespace('My\\Testing\\NamespaceName')
            ->addUse('My\\Testing\\ParentNamespace\\Model')
            ->addUse('My\\Testing\\ParentNamespace\\Repository')
            ->addUse('My\\Testing\\ParentNamespace\\Generator')
            ->addUse('My\\Testing\\ParentNamespace\\Foo', 'FooType', true)
            ->addInterfaceComponent($interface);

        $this->assertSameContent(__FUNCTION__, $file);
    }
}
