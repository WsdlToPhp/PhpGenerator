<?php

declare(strict_types=1);

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
    public function __construct(string $name, bool $abstract = false, ?string $extends = null, array $interfaces = [])
    {
        $this->setMainElement(new PhpInterfaceElement($name, $abstract, $extends, $interfaces));
    }
    /**
     * @param PhpMethodElement $method
     * @return PhpInterface
     */
    public function addMethodElement(PhpMethodElement $method): AbstractComponent
    {
        if ($method->getHasBody()) {
            $method->setHasBody(false);
        }
        return parent::addMethodElement($method);
    }
    /**
     * @param string $name
     * @param array $parameters
     * @param string $access
     * @param bool $abstract
     * @param bool $static
     * @param bool $final
     * @param bool $hasBody
     * @return PhpInterface
     */
    public function addMethod(string $name, array $parameters = [], string $access = PhpMethodElement::ACCESS_PUBLIC, bool $abstract = false, bool $static = false, bool $final = false, bool $hasBody = true): AbstractComponent
    {
        return $this->addMethodElement(new PhpMethodElement($name, $parameters, $access, $abstract, $static, $final, false));
    }
    /**
     * @param PhpPropertyElement $property
     * @return PhpInterface
     */
    public function addPropertyElement(PhpPropertyElement $property): AbstractComponent
    {
        return $this;
    }
    /**
     * @param string $name
     * @param string $value
     * @param string $access
     * @return PhpInterface
     */
    public function addProperty(string $name, $value = null, string $access = PhpPropertyElement::ACCESS_PUBLIC): AbstractComponent
    {
        return $this;
    }
}
