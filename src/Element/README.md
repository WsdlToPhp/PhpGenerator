# WsdlToPhp Php Generator, Element

This directory contains the basics. Any element contained by a PHP file should be here.

Using one of these elements, you can generate the content of a basic element:

- simple php file
- class: classic, abstract, interface
- method
- variable
- function
- property class
- constant
- annotation block

## Main features
### Generate any basic PHP source code you want using a flexible PHP library

#### Create a variable of any type
##### An integer
```php
$variable = new PhpVariable('bar', 1);
echo $variable->toString();
```
displays
```php
$bar = 1;
```
##### A string
```php
$variable = new PhpVariable('bar', '1');
echo $variable->toString();
```
displays
```php
$bar = '1';
```
##### An object
```php
$variable = new PhpVariable('bar', 'new DOMDocument(\'1.0\', \'utf-8\')');
echo $variable->toString();
```
displays
```php
$bar = new DOMDocument('1.0', 'utf-8');
```
##### The result of a function
```php
$variable = new PhpVariable('bar', 'is_array($foo)');
echo $variable->toString();
```
displays
```php
$bar = is_array($foo);
```
##### A class's constant
```php
$variable = new PhpVariable('bar', 'stdClass::FOO');
echo $variable->toString();
```
displays
```php
$bar = stdClass::FOO;
```
##### A global constant
```php
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
$constant = new PhpConstant('FOO', true);
echo $constant->toString();
```
displays
```php
define('FOO', true);
```
##### For a class
```php
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
$annotationBlock = new PhpAnnotationBlock();
$annotationBlock
    ->addChild(new PhpAnnotation('date', '2015-01-01'))
    ->addChild(new PhpAnnotation('author', 'PhpTeam'))
    ->addChild('This annotation is useful!');
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

$function
    ->addChild(new PhpVariable('bar', 1))
    ->addChild('return $bar;');
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

$method
    ->addChild(new PhpVariable('bar', 1))
    ->addChild('return $bar;');
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
$method = new PhpMethod('foo', array(
    'bar',
), PhpMethod::ACCESS_PUBLIC, false, false, false, false);
echo $method->toString();
```
displays
```php
public function foo($bar);
```

#### Create a class, an abstract class
##### Simple class without any method
```php
$class = new PhpClass('Foo');
echo $class->toString();
```
displays
```php
class Foo
{
}
```
##### Simple abstract class without any method
```php
$class = new PhpClass('Foo', true);
echo $class->toString();
```
displays
```php
abstract class Foo
{
}
```
##### Simple class without any method with inheritance
```php
$class = new PhpClass('Foo', false, 'Bar');
echo $class->toString();
```
displays
```php
class Foo extends Bar
{
}
```
##### Simple class without any method with implementation
```php
$class = new PhpClass('Foo', false, 'Bar', array(
    'Demo',
    'Sample',
));
// equivalent to:
$class = new PhpClass('Foo', false, 'Bar', array(
    new PhpClass('Demo'),
    new PhpClass('Sample'),
));
echo $class->toString();
```
displays
```php
class Foo extends Bar implements Demo, Sample
{
}
```
##### Class with one empty method
```php
$class = new PhpClass('Foo');
$class->addChild(new PhpMethod('bar'));
echo $class->toString();
```
displays
```php
class Foo
{
    public function bar()
    {
    }
}
```
##### Class with one method
```php
$class = new PhpClass('Foo');
$method = new PhpMethod('bar', array(
    'bar',
    'foo',
    'sample',
), PhpMethod::ACCESS_PRIVATE);
$method->addChild(new PhpVariable('foo', 1));
$class->addChild($method);
echo $class->toString();
```
displays
```php
class Foo
{
    private function bar($bar, $foo, $sample)
    {
        $foo = 1;
    }
}
```

#### Create an interface
##### Simple class without any method
```php
$interface = new PhpInterface('Foo');
echo $interface->toString();
```
displays
```php
interface Foo
{
}
```
##### Simple class with one method
```php
$interface = new PhpInterface('Foo');
$interface->addChild(new PhpMethod('bar'));
echo $interface->toString();
```
displays
```php
interface Foo
{
    public function bar();
}
```
##### Interface does not accept any property
```php
$interface = new PhpInterface('Foo');
$class->addChild(new PhpProperty('Bar'));
```
throws an ```\InvaliddArgumentException``` exception.

### Generate a file from a simple file to a class file
#### Containing one variable
```php
$file = new PhpFile('foo');
$file->addChild(new PhpVariable('foo', 1));
echo $file->toString();
```
displays
```php
<?php
$foo = 1;
```
#### Containing one constant
```php
$file = new PhpFile('foo');
$file->addChild(new PhpConstant('foo', 1));
echo $file->toString();
```
displays
```php
<?php
define('foo', 1);
```
#### Containing one function
```php
$file = new PhpFile('foo');
$file->addChild(new PhpFunction('foo', array(
    'foo',
    'sample',
    'demo',
)));
echo $file->toString();
```
displays
```php
<?php
function foo($foo, $sample, $demo)
{
}
```
#### Containing one annotation block
```php
$file = new PhpFile('foo');
$file->addChild(new PhpAnnotationBlock(array(
    'date is the key',
    'time is the core key',
)));
echo $file->toString();
```
displays
```php
<?php
/**
 * date is the key
 * time is the core key
 */
```
#### Containing an annotation block and a class
```php
$file = new PhpFile('foo');
$file->addChild(new PhpAnnotationBlock(array(
    'date is the key',
    'time is the core key',
)));
$class = new PhpClass('Foo');
$class->addChild(new PhpMethod('Bar'));
$file->addChild($class);
echo $file->toString();
```
displays
```php
<?php
/**
 * date is the key
 * time is the core key
 */
class Foo
{
    public function Bar()
    {
    }
}
```

## Main constraints
Each element must only have access to its sub content, this means a class does not care of its annotations:

- a file contains: constants, variables, annotation blocks, empty string lines, classes, functions, interfaces
- a class contains/an abstract class: constants, properties, methods, annotation blocks, empty string lines
- an interface contains: constants, methods, annotation blocks, empty string lines
- a method contains: variables, annotation blocks, string code lines, empty string lines
- a function contains: variables, string code lines, empty line, annotation blocks
- an annotation block contains: annotations
- variable, property, function parameter, annotation and constant can't contain any element

