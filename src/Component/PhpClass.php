<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Component;

use WsdlToPhp\PhpGenerator\Element\PhpClass as PhpClassElement;
use WsdlToPhp\PhpGenerator\Element\PhpMethod as PhpMethodElement;
use WsdlToPhp\PhpGenerator\Element\PhpProperty as PhpPropertyElement;

class PhpClass extends AbstractComponent
{
    public function __construct(string $name, bool $abstract = false, ?string $extends = null, array $interfaces = [])
    {
        $this->setMainElement(new PhpClassElement($name, $abstract, $extends, $interfaces));
    }

    public function addMethodElement(PhpMethodElement $method): self
    {
        $this->mainElement->addChild($method);

        return $this;
    }

    public function addMethod(string $name, array $parameters = [], ?string $returnType = null, string $access = PhpMethodElement::ACCESS_PUBLIC, bool $abstract = false, bool $static = false, bool $final = false, bool $hasBody = true): self
    {
        return $this->addMethodElement(new PhpMethodElement($name, $parameters, $returnType, $access, $abstract, $static, $final, $hasBody));
    }

    public function addPropertyElement(PhpPropertyElement $property): self
    {
        $this->mainElement->addChild($property);

        return $this;
    }

    public function addProperty(string $name, $value = null, string $access = PhpPropertyElement::ACCESS_PUBLIC, $type = null): self
    {
        return $this->addPropertyElement(new PhpPropertyElement($name, $value, $access, $type));
    }
}
