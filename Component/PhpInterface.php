<?php

namespace WsdlToPhp\PhpGenerator\Component;

use WsdlToPhp\PhpGenerator\Element\PhpInterface as PhpInterfaceElement;
use WsdlToPhp\PhpGenerator\Element\PhpProperty as PhpPropertyElement;
use WsdlToPhp\PhpGenerator\Element\PhpMethod as PhpMethodElement;

class PhpInterface extends PhpClass
{
    /**
     * @param string $name
     * @param bool $abstract
     * @param string $extends
     * @param array $interfaces
     */
    public function __construct($name, $abstract = false, $extends = null, array $interfaces = array())
    {
        $this->setMainElement(new PhpInterfaceElement($name, $abstract, $extends, $interfaces));
    }
    /**
     * @param PhpMethodElement $method
     * @return PhpInterface
     */
    public function addMethodElement(PhpMethodElement $method)
    {
        if ($method->getHasBody()) {
            $method->setHasBody(false);
        }
        return parent::addMethodElement($method);
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\PhpMethod::__construct()
     * @param string $name
     * @param array $parameters
     * @param string $access
     * @param bool $abstract
     * @param bool $static
     * @param bool $final
     * @param bool $hasBody
     * @return PhpInterface
     */
    public function addMethod($name, array $parameters = array(), $access = PhpMethodElement::ACCESS_PUBLIC, $abstract = false, $static = false, $final = false, $hasBody = true)
    {
        return $this->addMethodElement(new PhpMethodElement($name, $parameters, $access, $abstract, $static, $final, false));
    }
    /**
     * @param PhpPropertyElement $property
     * @return PhpInterface
     */
    public function addPropertyElement(PhpPropertyElement $property)
    {
        return $this;
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\PhpProperty::__construct()
     * @param string $name
     * @param string $value
     * @param string $access
     * @return PhpInterface
     */
    public function addProperty($name, $value = null, $access = PhpPropertyElement::ACCESS_PUBLIC)
    {
        return $this;
    }
}
