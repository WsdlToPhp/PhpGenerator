<?php

namespace WsdlToPhp\PhpGenerator\Component;

use WsdlToPhp\PhpGenerator\Element\PhpClass as PhpClassElement;
use WsdlToPhp\PhpGenerator\Element\PhpProperty as PhpPropertyElement;
use WsdlToPhp\PhpGenerator\Element\PhpMethod as PhpMethodElement;

class PhpClass extends AbstractComponent
{
    /**
     * @param string $name
     * @param bool $abstract
     * @param string $extends
     * @param array $interfaces
     */
    public function __construct($name, $abstract = false, $extends = null, array $interfaces = array())
    {
        $this->setMainElement(new PhpClassElement($name, $abstract, $extends, $interfaces));
    }
    /**
     * @param PhpMethodElement $method
     * @return PhpClass
     */
    public function addMethodElement(PhpMethodElement $method)
    {
        $this->mainElement->addChild($method);
        return $this;
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
     * @return PhpClass
     */
    public function addMethod($name, array $parameters = array(), $access = PhpMethodElement::ACCESS_PUBLIC, $abstract = false, $static = false, $final = false, $hasBody = true)
    {
        return $this->addMethodElement(new PhpMethodElement($name, $parameters, $access, $abstract, $static, $final, $hasBody));
    }
    /**
     * @param PhpPropertyElement $property
     * @return PhpClass
     */
    public function addPropertyElement(PhpPropertyElement $property)
    {
        $this->mainElement->addChild($property);
        return $this;
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\PhpProperty::__construct()
     * @param string $name
     * @param string $value
     * @param string $access
     * @return PhpClass
     */
    public function addProperty($name, $value = null, $access = PhpPropertyElement::ACCESS_PUBLIC)
    {
        return $this->addPropertyElement(new PhpPropertyElement($name, $value, $access));
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Component\AbstractComponent::getElements()
     * @return PhpClassElement[]
     */
    public function getElements()
    {
        return array(
            $this->getMainElement(),
        );
    }
}
