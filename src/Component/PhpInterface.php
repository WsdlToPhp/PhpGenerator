<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Component;

use WsdlToPhp\PhpGenerator\Element\PhpInterface as PhpInterfaceElement;
use WsdlToPhp\PhpGenerator\Element\PhpMethod as PhpMethodElement;
use WsdlToPhp\PhpGenerator\Element\PhpProperty as PhpPropertyElement;

class PhpInterface extends PhpClass
{
    public function __construct(string $name, bool $abstract = false, ?string $extends = null, array $interfaces = [])
    {
        $this->setMainElement(new PhpInterfaceElement($name, $abstract, $extends, $interfaces));
    }

    public function addMethodElement(PhpMethodElement $method): self
    {
        if ($method->getHasBody()) {
            $method->setHasBody(false);
        }

        parent::addMethodElement($method);

        return $this;
    }

    public function addMethod(string $name, array $parameters = [], ?string $returnType = null, string $access = PhpMethodElement::ACCESS_PUBLIC, bool $abstract = false, bool $static = false, bool $final = false, bool $hasBody = true): self
    {
        return $this->addMethodElement(new PhpMethodElement($name, $parameters, $returnType, $access, $abstract, $static, $final, false));
    }

    public function addPropertyElement(PhpPropertyElement $property): self
    {
        return $this;
    }

    public function addProperty(string $name, $value = null, string $access = PhpPropertyElement::ACCESS_PUBLIC, $type = null): self
    {
        return $this;
    }
}
