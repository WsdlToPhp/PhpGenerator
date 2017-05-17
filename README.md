# WsdlToPhp Php Generator, a Real PHP source code generator
[![License](https://poser.pugx.org/wsdltophp/phpgenerator/license)](https://packagist.org/packages/wsdltophp/phpgenerator)
[![Latest Stable Version](https://poser.pugx.org/wsdltophp/phpgenerator/version.png)](https://packagist.org/packages/wsdltophp/phpgenerator)
[![Build Status](https://api.travis-ci.org/WsdlToPhp/PhpGenerator.svg)](https://travis-ci.org/WsdlToPhp/PhpGenerator)
[![PHP 7 ready](http://php7ready.timesplinter.ch/WsdlToPhp/PhpGenerator/badge.svg)](https://travis-ci.org/WsdlToPhp/PhpGenerator)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/WsdlToPhp/PhpGenerator/badges/quality-score.png)](https://scrutinizer-ci.com/g/WsdlToPhp/PhpGenerator/)
[![Code Coverage](https://scrutinizer-ci.com/g/WsdlToPhp/PhpGenerator/badges/coverage.png)](https://scrutinizer-ci.com/g/WsdlToPhp/PhpGenerator/)
[![Dependency Status](https://www.versioneye.com/user/projects/5571b32b6634650018000011/badge.svg)](https://www.versioneye.com/user/projects/5571b32b6634650018000011)
[![StyleCI](https://styleci.io/repos/36832375/shield)](https://styleci.io/repos/36832375)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e55e9115-5a3f-4d37-bfd5-b01c8de579f9/mini.png)](https://insight.sensiolabs.com/projects/e55e9115-5a3f-4d37-bfd5-b01c8de579f9)

Even if this project is yet another PHP source code generator, its main goal is to provide a consistent PHP source code generator for the [PackageGenerator](https://github.com/WsdlToPhp/PackageGenerator) project. Nevertheless, it also aims to be used for any PHP source code generation process as it generates standard PHP code.

Rest assured that it is not tweaked for the purpose of the [PackageGenerator](https://github.com/WsdlToPhp/PackageGenerator) project.

## Main features
This projet contains two main features:

- [Element](src/Element/README.md): generate basic elements
- [Component](src/Component/README.md): generate structured complex elements

## Unit tests
You can run the unit tests with the following command:
```
    $ cd /path/to/src/WsdlToPhp/PhpGenerator/
    $ composer install
    $ phpunit
```
