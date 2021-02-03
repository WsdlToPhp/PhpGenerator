# UPGRADE FROM 3.* to 4.*

The main change is that `PhpProperty` are now type hinted in addition to internal methods removal and introduction of Interfaces and Traits
- `WsdlToPhp\PhpGenerator\Element\PhpProperty::__construct` has a new parameter in the end named `$type` which can be any of the regular PHP types, or any existing PHP class or a PhpClass element or a string or a null value

Apart from that, the usage did not change, the inner classes has changed which should not be an issue if you did not inherit from them. Otherwise, launch your unit tests ;).
