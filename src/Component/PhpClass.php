<?php

declare(strict_types=1);

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
    public function __construct(string $name, bool $abstract = false, ?string $extends = null, array $interfaces = [])
    {
        $this->setMainElement(new PhpClassElement($name, $abstract, $extends, $interfaces));
    }
    /**
     * @param PhpMethodElement $method
     * @return PhpClass
     */
    public function addMethodElement(PhpMethodElement $method): AbstractComponent
    {
        $this->mainElement->addChild($method);
        return $this;
    }
    /**
     * @param string $name
     * @param array $parameters
     * @param string $access
     * @param bool $abstract
     * @param bool $static
     * @param bool $final
     * @param bool $hasBody
     * @return PhpClass
     */
    public function addMethod(string $name, array $parameters = [], string $access = PhpMethodElement::ACCESS_PUBLIC, bool $abstract = false, bool $static = false, bool $final = false, bool $hasBody = true): AbstractComponent
    {
        return $this->addMethodElement(new PhpMethodElement($name, $parameters, $access, $abstract, $static, $final, $hasBody));
    }
    /**
     * @param PhpPropertyElement $property
     * @return PhpClass
     */
    public function addPropertyElement(PhpPropertyElement $property): AbstractComponent
    {
        $this->mainElement->addChild($property);
        return $this;
    }
    /**
     * @param string $name
     * @param string $value
     * @param string $access
     * @return PhpClass
     */
    public function addProperty(string $name, $value = null, string $access = PhpPropertyElement::ACCESS_PUBLIC): AbstractComponent
    {
        return $this->addPropertyElement(new PhpPropertyElement($name, $value, $access));
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Component\AbstractComponent::getElements()
     * @return PhpClassElement[]
     */
    public function getElements(): array
    {
        return [
            $this->getMainElement(),
        ];
    }
}
