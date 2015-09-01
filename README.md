# WsdlToPhp Php Generator, a Real PHP source code generator
[![Latest Stable Version](https://poser.pugx.org/wsdltophp/phpgenerator/version.png)](https://packagist.org/packages/wsdltophp/phpgenerator)
[![Build Status](https://api.travis-ci.org/WsdlToPhp/PhpGenerator.svg)](https://travis-ci.org/WsdlToPhp/PhpGenerator)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/WsdlToPhp/PhpGenerator/badges/quality-score.png)](https://scrutinizer-ci.com/g/WsdlToPhp/PhpGenerator/)
[![Code Coverage](https://scrutinizer-ci.com/g/WsdlToPhp/PhpGenerator/badges/coverage.png)](https://scrutinizer-ci.com/g/WsdlToPhp/PhpGenerator/)
[![Dependency Status](https://www.versioneye.com/user/projects/5571b32b6634650018000011/badge.svg)](https://www.versioneye.com/user/projects/5571b32b6634650018000011)

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