# UPGRADE FROM 2.* to 3.*

The main change, apart from requiring PHP >= 7.4, is that `PhpFunction` and `PhpMethod` now accepts a `$returnType` parameter which impacts four locations:
- `WsdlToPhp\PhpGenerator\Element\PhpFunction::__construct` has a new parameter after the `$parameters` parameter named `$returnType` which is a string allowing to set the function return type
- `WsdlToPhp\PhpGenerator\Element\PhpMethod::__construct` has a new parameter after the `$parameters` parameter named `$returnType` which is a string allowing to set the method return type
- `WsdlToPhp\PhpGenerator\Component\PhpClass::addMethod` has a new parameter after the `$parameters` parameter named `$returnType` which is a string allowing to set the method return type
- `WsdlToPhp\PhpGenerator\Component\PhpInterface::addMethod` has a new parameter after the `$parameters` parameter named `$returnType` which is a string allowing to set the method return type

**Previously**:
```php
$phpFunction = new PhpFunction('name', ['firstParameter', 'secondParameter']);

$phpMethod = new PhpMethod('name', ['firstParameter', 'secondParameter'], PhpMethod::ACCESS_PUBLIC);

$phpClass = (new PhpClass('MyClass'))
    ->addMethod('name', ['firstParameter', 'secondParameter'], PhpMethod::ACCESS_PUBLIC);

$phpInterface = (new PhpInterface('MyInterface'))
    ->addMethod('name', ['firstParameter', 'secondParameter'], PhpMethod::ACCESS_PUBLIC);
```

**Now**:
```php
$phpFunction = new PhpFunction('name', ['firstParameter', 'secondParameter'] /*, 'int' or '?int' or '?App\\Entity\\MyEntity'*/);

$phpMethod = new PhpMethod('name', ['firstParameter', 'secondParameter'], null /*, 'int' or '?int' or '?App\\Entity\\MyEntity'*/, PhpMethod::ACCESS_PUBLIC);

$phpClass = (new PhpClass('MyClass'))
    ->addMethod('name', ['firstParameter', 'secondParameter'], null /*, 'int' or '?int' or '?App\\Entity\\MyEntity'*/, PhpMethod::ACCESS_PUBLIC);

$phpInterface = (new PhpInterface('MyInterface'))
    ->addMethod('name', ['firstParameter', 'secondParameter'], null /*, 'int' or '?int' or '?App\\Entity\\MyEntity'*/, PhpMethod::ACCESS_PUBLIC);
```
