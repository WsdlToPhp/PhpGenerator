# PhpGenerator Component

This directory contains the components that are on top of element as component can contain elements and eases generation of more complex elements.

Using one of these components, you can generate the content of more complex element:

- complete php file
- class: classic, abstract, interface

## Main features
### Generate a complete class
```php
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
        '@return mixed'
    ])
    ->addMethod('getMyValue', [
        new PhpFunctionParameterElement('asString', true),
        'unusedParameter'
    ])
    ->addAnnotationBlock([
        new PhpAnnotationElement(PhpAnnotationElement::NO_NAME, 'This method is very useless'),
        new PhpAnnotationElement('date', '2012-03-01'),
        '@return void'
    ])
    ->addMethod('uselessMethod', [
        new PhpFunctionParameterElement('uselessParameter', null),
        'unusedParameter'
    ]);
echo $class->toString();
```
displays
```php
abstract class Foo extends stdClass
{
    /**
     * @var string
     */
    const FOO = 'theValue';
    /**
     * @var string
     */
    const BAR = 'theOtherValue';
    /**
     * @var int
     */
    public $bar = 1;
    /**
     * @var bool
     */
    public $sample = true;
    /**
     * This method is very useful
     * @date 2012-03-01
     * @return mixed
     */
    public function getMyValue($asString = true, $unusedParameter)
    {
    }
    /**
     * This method is very useless
     * @date 2012-03-01
     * @return void
     */
    public function uselessMethod($uselessParameter = null, $unusedParameter)
    {
    }
}
```
### Generate a complete PHP file with a class
```php
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
        '@return mixed'
    ])
    ->addMethod('getMyValue', [
        new PhpFunctionParameterElement('asString', true),
        'unusedParameter'
    ])
    ->addAnnotationBlock([
        new PhpAnnotationElement(PhpAnnotationElement::NO_NAME, 'This method is very useless'),
        new PhpAnnotationElement('date', '2012-03-01'),
        '@return void'
    ])
    ->addMethod('uselessMethod', [
        new PhpFunctionParameterElement('uselessParameter', null),
        'unusedParameter'
    ]);
$file
    ->setDeclare(PhpDeclare::DIRECTIVE_STRICT_TYPES, 1)
    ->setNamespace('My\\Testing\\NamespaceName')
    ->addUse('My\\Testing\\ParentNamespace\\Model')
    ->addUse('My\\Testing\\ParentNamespace\\Repository')
    ->addUse('My\\Testing\\ParentNamespace\\Generator')
    ->addUse('My\\Testing\\ParentNamespace\\Foo', 'FooType')
    ->addClassComponent($class);
echo $file->toString();
```
displays
```php
<?php

declare(strict_types=1);

namespace My\Testing\NamespaceName;

use My\Testing\ParentNamespace\Model;
use My\Testing\ParentNamespace\Repository;
use My\Testing\ParentNamespace\Generator;
use My\Testing\ParentNamespace\Foo as FooType;

abstract class Foo extends stdClass
{
    /**
     * @var string
     */
    const FOO = 'theValue';
    /**
     * @var string
     */
    const BAR = 'theOtherValue';
    /**
     * @var int
     */
    public $bar = 1;
    /**
     * @var bool
     */
    public $sample = true;
    /**
     * This method is very useful
     * @date 2012-03-01
     * @return mixed
     */
    public function getMyValue($asString = true, $unusedParameter)
    {
    }
    /**
     * This method is very useless
     * @date 2012-03-01
     * @return void
     */
    public function uselessMethod($uselessParameter = null, $unusedParameter)
    {
    }
}
```

