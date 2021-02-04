<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Tests\Component;

use InvalidArgumentException;
use WsdlToPhp\PhpGenerator\Component\PhpClass as PhpClassComponent;
use WsdlToPhp\PhpGenerator\Component\PhpFile as PhpFileComponent;
use WsdlToPhp\PhpGenerator\Component\PhpInterface as PhpInterfaceComponent;
use WsdlToPhp\PhpGenerator\Element\PhpAnnotation as PhpAnnotationElement;
use WsdlToPhp\PhpGenerator\Element\PhpDeclare;
use WsdlToPhp\PhpGenerator\Element\PhpFile;
use WsdlToPhp\PhpGenerator\Element\PhpFunctionParameter as PhpFunctionParameterElement;
use WsdlToPhp\PhpGenerator\Element\PhpProperty;
use WsdlToPhp\PhpGenerator\Element\PhpProperty as PhpPropertyElement;

/**
 * @internal
 * @coversDefaultClass
 */
class PhpFileTest extends AbstractComponent
{
    public function testGetMainElementMustBeOfPhpFileElement()
    {
        $class = new PhpFileComponent('Foo', true, 'stdClass');

        $this->assertInstanceOf(PhpFile::class, $class->getMainElement());
    }

    public function testSimpleClassToString()
    {
        $file = new PhpFileComponent('Foo');
        $class = new PhpClassComponent('Foo', true, 'stdClass');

        $class
            ->addAnnotationBlock('@var string')
            ->addConstant('FOO', 'theValue')
            ->addString()
            ->addAnnotationBlock('@var string')
            ->addConstant('BAR', 'theOtherValue')
            ->addString()
            ->addAnnotationBlock(new PhpAnnotationElement('var', 'int'))
            ->addProperty('bar', 1, PhpProperty::ACCESS_PRIVATE, PhpProperty::TYPE_INT)
            ->addString()
            ->addAnnotationBlock(new PhpAnnotationElement('var', 'bool'))
            ->addPropertyElement(new PhpPropertyElement('sample', true))
            ->addString()
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

        $declare = (new PhpDeclare(PhpDeclare::DIRECTIVE_STRICT_TYPES, 1))
            ->addChild(new PhpDeclare(PhpDeclare::DIRECTIVE_ENCODING, 'UTF-8'))
        ;

        $file
            ->setDeclareElement($declare)
            ->setNamespace('My\\Testing\\NamespaceName')
            ->addUse('My\\Testing\\ParentNamespace\\Model')
            ->addUse('My\\Testing\\ParentNamespace\\Repository')
            ->addUse('My\\Testing\\ParentNamespace\\Generator')
            ->addUse('My\\Testing\\ParentNamespace\\Foo', 'FooType', true)
            ->addClassComponent($class)
        ;

        $this->assertSameContent(__FUNCTION__, $file);
    }

    public function testSimpleClassToStringWithReturnType()
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
            ->addMethod('getMyEntity', [
                new PhpFunctionParameterElement('entityId', PhpFunctionParameterElement::NO_VALUE, 'string'),
            ], 'My\\Testing\\ParentNamespace\\Entity')
        ;

        $declare = (new PhpDeclare(PhpDeclare::DIRECTIVE_STRICT_TYPES, 1))
            ->addChild(new PhpDeclare(PhpDeclare::DIRECTIVE_ENCODING, 'UTF-8'))
        ;

        $file
            ->setDeclareElement($declare)
            ->setNamespace('My\\Testing\\NamespaceName')
            ->addUse('My\\Testing\\ParentNamespace\\Model')
            ->addUse('My\\Testing\\ParentNamespace\\Repository')
            ->addUse('My\\Testing\\ParentNamespace\\Entity')
            ->addUse('My\\Testing\\ParentNamespace\\Generator')
            ->addUse('My\\Testing\\ParentNamespace\\Foo', 'FooType', true)
            ->addClassComponent($class)
        ;

        $this->assertSameContent(__FUNCTION__, $file);
    }

    public function testSetMainElementWithException()
    {
        $this->expectException(InvalidArgumentException::class);

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

        $file->addFunction('name', [
            'bar',
        ]);

        $this->assertSame("<?php\nfunction name(\$bar)\n{\n}\n", $file->toString());
    }

    public function testSimpleInterfaceToString()
    {
        $file = new PhpFileComponent('Foo');
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

        $file
            ->setDeclare(PhpDeclare::DIRECTIVE_STRICT_TYPES, 1)
            ->setNamespace('My\\Testing\\NamespaceName')
            ->addUse('My\\Testing\\ParentNamespace\\Model')
            ->addUse('My\\Testing\\ParentNamespace\\Repository')
            ->addUse('My\\Testing\\ParentNamespace\\Generator')
            ->addUse('My\\Testing\\ParentNamespace\\Foo', 'FooType', true)
            ->addInterfaceComponent($interface)
        ;

        $this->assertSameContent(__FUNCTION__, $file);
    }
}
