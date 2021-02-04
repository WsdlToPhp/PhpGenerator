<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Tests\Component;

use WsdlToPhp\PhpGenerator\Component\PhpClass as PhpClassComponent;
use WsdlToPhp\PhpGenerator\Element\PhpAnnotation as PhpAnnotationElement;
use WsdlToPhp\PhpGenerator\Element\PhpClass;
use WsdlToPhp\PhpGenerator\Element\PhpFunctionParameter as PhpFunctionParameterElement;
use WsdlToPhp\PhpGenerator\Element\PhpProperty;
use WsdlToPhp\PhpGenerator\Element\PhpProperty as PhpPropertyElement;

/**
 * @internal
 * @coversDefaultClass
 */
class PhpClassTest extends AbstractComponent
{
    public function testGetMainElementMustBeOfPhpClassElement()
    {
        $class = new PhpClassComponent('Foo', true, 'stdClass');

        $this->assertInstanceOf(PhpClass::class, $class->getMainElement());
    }

    public function testSimpleToString()
    {
        $class = new PhpClassComponent('Foo', true, 'stdClass');

        $class
            ->addAnnotationBlock('@var string')
            ->addConstant('FOO', 'theValue')
            ->addAnnotationBlock('@var string')
            ->addConstant('BAR', 'theOtherValue')
            ->addAnnotationBlock(new PhpAnnotationElement('var', 'int'))
            ->addProperty('bar', 1, PhpProperty::ACCESS_PRIVATE, PhpProperty::TYPE_INT)
            ->addAnnotationBlock([
                '- documentation: The ID of the contact that performed the action, if available. May be blank for anonymous activity.',
                new PhpAnnotationElement('var', 'bool'),
            ])
            ->addPropertyElement(new PhpPropertyElement('sample', true))
            ->addAnnotationBlock(new PhpAnnotationElement('var', 'string'))
            ->addPropertyElement(new PhpPropertyElement('noValue', PhpPropertyElement::NO_VALUE))
            ->addAnnotationBlock([
                new PhpAnnotationElement(PhpAnnotationElement::NO_NAME, 'This method is very useful'),
                new PhpAnnotationElement('date', '2012-03-01'),
                '@return mixed',
            ])
            ->addMethod('getMyValue', [
                new PhpFunctionParameterElement('asString', true),
                'unusedParameter',
            ])
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

        $this->assertSameContent(__FUNCTION__, $class);
    }

    public function testSimpleToStringWithReturnTypePerMethod()
    {
        $class = new PhpClassComponent('Foo', true, 'stdClass');

        $class
            ->addAnnotationBlock('@var string')
            ->addConstant('FOO', 'theValue')
            ->addAnnotationBlock('@var string')
            ->addConstant('BAR', 'theOtherValue')
            ->addAnnotationBlock(new PhpAnnotationElement('var', 'int'))
            ->addProperty('bar', 1)
            ->addAnnotationBlock([
                '- documentation: The ID of the contact that performed the action, if available. May be blank for anonymous activity.',
                new PhpAnnotationElement('var', 'bool'),
            ])
            ->addPropertyElement(new PhpPropertyElement('sample', true))
            ->addAnnotationBlock(new PhpAnnotationElement('var', 'string'))
            ->addPropertyElement(new PhpPropertyElement('noValue', PhpPropertyElement::NO_VALUE))
            ->addAnnotationBlock([
                new PhpAnnotationElement(PhpAnnotationElement::NO_NAME, 'This method is very useful'),
                new PhpAnnotationElement('date', '2012-03-01'),
                '@return mixed',
            ])
            ->addMethod('getMyValue', [
                new PhpFunctionParameterElement('asString', true),
                'unusedParameter',
            ])
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

        $this->assertSameContent(__FUNCTION__, $class);
    }

    public function testSimpleToStringWithNullableReturnTypePerMethod()
    {
        $class = new PhpClassComponent('Foo', true, 'stdClass');

        $class
            ->addAnnotationBlock('@var string')
            ->addConstant('FOO', 'theValue')
            ->addAnnotationBlock('@var string')
            ->addConstant('BAR', 'theOtherValue')
            ->addAnnotationBlock(new PhpAnnotationElement('var', 'int'))
            ->addProperty('bar', 1)
            ->addAnnotationBlock([
                '- documentation: The ID of the contact that performed the action, if available. May be blank for anonymous activity.',
                new PhpAnnotationElement('var', 'bool'),
            ])
            ->addPropertyElement(new PhpPropertyElement('sample', true))
            ->addAnnotationBlock(new PhpAnnotationElement('var', 'string'))
            ->addPropertyElement(new PhpPropertyElement('noValue', PhpPropertyElement::NO_VALUE))
            ->addAnnotationBlock([
                new PhpAnnotationElement(PhpAnnotationElement::NO_NAME, 'This method is very useful'),
                new PhpAnnotationElement('date', '2012-03-01'),
                '@return mixed',
            ])
            ->addMethod('getMyValue', [
                new PhpFunctionParameterElement('asString', true),
                'unusedParameter',
            ])
            ->addAnnotationBlock([
                new PhpAnnotationElement(PhpAnnotationElement::NO_NAME, 'This method is very useless'),
                new PhpAnnotationElement('date', '2012-03-01'),
                '@return int|null',
            ])
            ->addMethod('uselessMethod', [
                new PhpFunctionParameterElement('uselessParameter', null),
                'unusedParameter',
            ], '?int')
        ;

        $this->assertSameContent(__FUNCTION__, $class);
    }
}
