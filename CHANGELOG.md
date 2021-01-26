# CHANGELOG

## X.0.0 - 2021/xx/xx
- use `splitbrain/phpfarm:jessie` as Docker image and fix docker image settings
- Code requires PHP >= 7.4
- Code cleaning
- BC:
    - `WsdlToPhp\PhpGenerator\Element\PhpFunction::__construct` has a new parameter after the `$parameters` parameter named `$returnType` which is a string allowing to set the function return type
    - `WsdlToPhp\PhpGenerator\Element\PhpMethod::__construct` has a new parameter after the `$parameters` parameter named `$returnType` which is a string allowing to set the method return type
    - `WsdlToPhp\PhpGenerator\Component\PhpClass::__addMethod` has a new parameter after the `$parameters` parameter named `$returnType` which is a string allowing to set the method return type
    - `WsdlToPhp\PhpGenerator\Component\PhpInterface::__addMethod` has a new parameter after the `$parameters` parameter named `$returnType` which is a string allowing to set the method return type
- Implementation of the PHP `declare` statement
- `GenerateableInterface` elements and components now implement the `__toString` method
- Update READMEs
- Update Travis CI settings
- Update PHPUnit settings
- Update LICENSE file

## 2.0.0
- Use PHP 7.1 features
- Refactore code
- Fix typos

## 1.2.1
- Review filemode, add SensioLabs Insight badge

## 1.2.0
- issue #7 - Improve Exception message

## 1.1.0
- issue #5 - No autocomplete because of return type on a new line after @return in annotation

## 1.0.1
- issue #4 - Cyrillic alphabet is not handled well

## 1.0.0
- First major release

## 1.0.0RC01
- Major: update source code structure, put Component and Element fodlers under ```src``` fodler, update composer and phpunit accordingly

## 0.0.16
- Minor: correct annotation

## 0.0.15
- Issue #3: fix constant declaration for specific value containing (
 
## 0.0.14
- Improvement: make annotation splitting more clever using word wrap in order to keep 

## 0.0.13
- Issue #2 : allow backslash for function/method parameter type

## 0.0.12
- Refactoring : Use statements and Namespace are contained by a file not a class as each element should only knows what it contains not what that is around itself.

## 0.0.11
- Issue : allow backslash within class name for namespace

## 0.0.10
- Allow to provide annotation max length to use

## 0.0.9
- Fix issue : within a class, the additonal multi lines are not indented correcly

## 0.0.8
- Fix issue: workaround for known var_export issue with float value

## 0.0.7
- Fix issue: if variable has 'news' as value, the variable is generated with news instead of 'news'

## 0.0.6
- Improvement: improve lisiblity and extensibility for PhpVariable and PhpFunctionParameter

## 0.0.5
- Fix issue: function parameter type is not tooken into account

## 0.0.4
- Fix issue regarding property/variable that has no value but always has a null value assigned with an assignment sign

## 0.0.3
- Apply PSR-2 rule: All PHP files MUST end with a single blank line.

## 0.0.2
- Code coverage improved
- Several methods have been refactored to minimize them and consolidate them
- Component/PhpInterface has been added
- Component/PhpFile has been cleaned and enhanced
- Component/PhpClass has been cleaned
- Component/AbstractComponent has been enhanced

## 0.0.1
- Initial version
