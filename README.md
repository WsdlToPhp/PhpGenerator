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

#### Create a simple variable
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