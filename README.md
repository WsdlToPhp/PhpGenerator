# WsdlToPhp Php Generator, a Real PHP source code generator
[![Build Status](https://api.travis-ci.org/WsdlToPhp/PhpGenerator.svg)](https://travis-ci.org/WsdlToPhp/PhpGenerator)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/WsdlToPhp/PhpGenerator/badges/quality-score.png)](https://scrutinizer-ci.com/g/WsdlToPhp/PhpGenerator/)

Php Generator eases the creation of a PHP file for any type of content such as:
- simple php file
- class file: abstract, interface, normal class
- method
- variable
- function
- property class
- etc

## Main features
### Generate any PHP source code you want using a flexible PHP library.

#### Create a variable of any type
##### An integer
```php
<?php
$variable = new PhpVariable('bar', 1);
echo $variable->toString();
```
displays
```php
$bar = 1;
```
##### A string
```php
<?php
$variable = new PhpVariable('bar', '1');
echo $variable->toString();
```
displays
```php
$bar = '1';
```
##### An object
```php
<?php
$variable = new PhpVariable('bar', 'new DOMDocument(\'1.0\', \'utf-8\')');
echo $variable->toString();
```
displays
```php
$bar = new DOMDocument('1.0', 'utf-8');
```
##### The result of a function
```php
<?php
$variable = new PhpVariable('bar', 'is_array($foo)');
echo $variable->toString();
```
displays
```php
$bar = is_array($foo);
```
##### A class's constant
```php
<?php
$variable = new PhpVariable('bar', 'stdClass::FOO');
echo $variable->toString();
```
displays
```php
$bar = stdClass::FOO;
```
##### A global constant
```php
<?php
$variable = new PhpVariable('bar', '::XML_ELEMENT_NODE');
echo $variable->toString();
```
displays
```php
$bar = XML_ELEMENT_NODE;
```

#### Create a constant
##### As global
```php
<?php
$constant = new PhpConstant('FOO', true);
echo $constant->toString();
```
displays
```php
define('FOO', true);
```
##### For a class
```php
<?php
$constant = new PhpConstant('foo', true, new PhpClass('Bar'));
echo $constant->toString();
```
displays
```php
const FOO = true;
```

#### Create an annotation block
##### Simple
```php
<?php
$annotationBlock = new PhpAnnotationBlock(array(
    'This sample annotation is on one line',
));
echo $annotationBlock->toString();
```
displays
```php
/**
 * This sample annotation is on one line
 */
```
##### More complex
```php
<?php
$annotationBlock = new PhpAnnotationBlock();
$annotationBlock->addChild(new PhpAnnotation('date', '2015-01-01'));
$annotationBlock->addChild(new PhpAnnotation('author', 'PhpTeam'));
$annotationBlock->addChild('This annotation is useful!');
echo $annotationBlock->toString();
```
displays
```php
/**
 * @date 2015-01-01
 * @author PhpTeam
 * This annotation is useful!
 */
```

#### Create a function
##### Simple function without any body
```php
<?php
$function = new PhpFunction('foo', array(
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
echo $function->toString();
```
displays
```php
function foo($bar, $demo = 1, $sample = NULL, $deamon = true)
{
}
```
##### Function with a body
```php
<?php
$function = new PhpFunction('foo', array(
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

$function->addChild(new PhpVariable('bar', 1));
$function->addChild('return $bar;');
echo $function->toString();
```
displays
```php
function foo($bar, $demo = 1, $sample = NULL, $deamon = true)
{
    $bar = 1;
    return $bar;
}
```

#### Create a method
##### Simple public method without any body
```php
<?php
$method = new PhpMethod('foo', array(
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
echo $method->toString();
```
displays
```php
public function foo($bar, $demo = 1, $sample = NULL, $deamon = true)
{
}
```
##### Simple public method with a body
```php
<?php
$method = new PhpMethod('foo', array(
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

$method->addChild(new PhpVariable('bar', 1));
$method->addChild('return $bar;');
echo $method->toString();
```
displays
```php
public function foo($bar, $demo = 1, $sample = NULL, $deamon = true)
{
    $bar = 1;
    return $bar;
}
```
##### Simple protected method without any body
```php
<?php
$method = new PhpMethod('foo', array(
    'bar',
), PhpMethod::ACCESS_PROTECTED);
echo $method->toString();
```
displays
```php
protected function foo($bar)
{
}
```
##### Simple private method without any body
```php
<?php
$method = new PhpMethod('foo', array(
    'bar',
), PhpMethod::ACCESS_PRIVATE);
echo $method->toString();
```
displays
```php
private function foo($bar)
{
}
```
##### Simple abstract public method without any body
```php
<?php
$method = new PhpMethod('foo', array(
    'bar',
), PhpMethod::ACCESS_PUBLIC, true);
echo $method->toString();
```
displays
```php
abstract public function foo($bar);
```
##### Simple static public method without any body
```php
<?php
$method = new PhpMethod('foo', array(
    'bar',
), PhpMethod::ACCESS_PUBLIC, false, true);
echo $method->toString();
```
displays
```php
public static function foo($bar)
{
}
```
##### Simple final public method without any body
```php
<?php
$method = new PhpMethod('foo', array(
    'bar',
), PhpMethod::ACCESS_PUBLIC, false, false, true);
echo $method->toString();
```
displays
```php
final public function foo($bar)
{
}
```
##### Simple public method with no body asked
```php
<?php
$method = new PhpMethod('foo', array(
    'bar',
), PhpMethod::ACCESS_PUBLIC, false, false, false, false);
echo $method->toString();
```
displays
```php
public function foo($bar);
```

### Generate PHP file from simple file to class file.

## Main constraints
Each element must only have access to its sub content, this means a class does not care of its annotations:
- a file contains: anything you want
- a class contains: constants, properties, methods, annotations, empty string lines
- an interface contains: constants, methods, annotations, empty string lines
- an abstract class contains: constants, properties, methods, annotations, empty string lines
- a method contains: variables, annotations, string code lines, empty string lines
- a function contains: variables, string code lines, empty line

## Unit tests
You can run the unit tests with the following command:
```
    $ cd /path/to/src/WsdlToPhp/PhpGenerator/
    $ composer install
    $ phpunit
```