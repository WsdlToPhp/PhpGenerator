<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Component;

use WsdlToPhp\PhpGenerator\Component\PhpClass as PhpClassComponent;
use WsdlToPhp\PhpGenerator\Component\PhpInterface as PhpInterfaceComponent;
use WsdlToPhp\PhpGenerator\Element\PhpDeclare;
use WsdlToPhp\PhpGenerator\Element\PhpFile as PhpFileElement;
use WsdlToPhp\PhpGenerator\Element\PhpFunction as PhpFunctionElement;
use WsdlToPhp\PhpGenerator\Element\PhpVariable as PhpVariableElement;

class PhpFile extends AbstractComponent
{
    public function __construct(string $name)
    {
        $this->setMainElement(new PhpFileElement($name));
    }

    public function addClassComponent(PhpClassComponent $class): self
    {
        $this->mainElement->addChild($class->toString());

        return $this;
    }

    public function addInterfaceComponent(PhpInterfaceComponent $interface): self
    {
        $this->mainElement->addChild($interface->toString());

        return $this;
    }

    public function addVariableElement(PhpVariableElement $variable): self
    {
        $this->mainElement->addChild($variable);

        return $this;
    }

    public function addVariable(string $name, $value = null): self
    {
        return $this->addVariableElement(new PhpVariableElement($name, $value));
    }

    public function addFunctionElement(PhpFunctionElement $function): self
    {
        $this->mainElement->addChild($function);

        return $this;
    }

    public function addFunction(string $name, array $parameters = []): self
    {
        return $this->addFunctionElement(new PhpFunctionElement($name, $parameters));
    }

    public function addUse(string $use, string $as = null, bool $last = false): self
    {
        $expression = empty($as) ? 'use %1$s;%3$s' : 'use %1$s as %2$s;%3$s';
        $this->mainElement->addChild(sprintf($expression, $use, $as, $last ? self::BREAK_LINE_CHAR : ''));

        return $this;
    }

    public function setDeclareElement(PhpDeclare $phpDeclare): self
    {
        $this->mainElement->addChild(sprintf('%s%s', self::BREAK_LINE_CHAR, $phpDeclare->toString()));

        return $this;
    }

    public function setDeclare(string $name, $value): self
    {
        return $this->setDeclareElement(new PhpDeclare($name, $value));
    }

    public function setNamespace(string $namespace): self
    {
        $this->mainElement->addChild(
            sprintf(
                '%snamespace %s;%s',
                self::BREAK_LINE_CHAR,
                $namespace,
                self::BREAK_LINE_CHAR
            )
        );

        return $this;
    }
}
