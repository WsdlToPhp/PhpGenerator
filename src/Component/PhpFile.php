<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Component;

use WsdlToPhp\PhpGenerator\Element\PhpFile as PhpFileElement;
use WsdlToPhp\PhpGenerator\Element\PhpVariable as PhpVariableElement;
use WsdlToPhp\PhpGenerator\Element\PhpFunction as PhpFunctionElement;
use WsdlToPhp\PhpGenerator\Component\PhpClass as PhpClassComponent;
use WsdlToPhp\PhpGenerator\Component\PhpInterface as PhpInterfaceComponent;

class PhpFile extends AbstractComponent
{
    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->setMainElement(new PhpFileElement($name));
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Component\AbstractComponent::getElements()
     * @return PhpFileElement[]
     */
    public function getElements(): array
    {
        return [
            $this->getMainElement(),
        ];
    }
    /**
     * @param PhpClassComponent $class
     * @return PhpFile
     */
    public function addClassComponent(PhpClassComponent $class): PhpFile
    {
        $this->mainElement->addChild($class->toString());
        return $this;
    }
    /**
     * @param PhpInterfaceComponent $interface
     * @return PhpFile
     */
    public function addInterfaceComponent(PhpInterfaceComponent $interface): PhpFile
    {
        $this->mainElement->addChild($interface->toString());
        return $this;
    }
    /**
     * @param PhpVariableElement $variable
     * @return PhpFile
     */
    public function addVariableElement(PhpVariableElement $variable): PhpFile
    {
        $this->mainElement->addChild($variable);
        return $this;
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\PhpVariable::__construct()
     * @param string $name
     * @param mixed $value
     * @return PhpFile
     */
    public function addVariable(string $name, $value = null): PhpFile
    {
        return $this->addVariableElement(new PhpVariableElement($name, $value));
    }
    /**
     * @param PhpFunctionElement $function
     * @return PhpFile
     */
    public function addFunctionElement(PhpFunctionElement $function): PhpFile
    {
        $this->mainElement->addChild($function);
        return $this;
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\PhpFunction::__construct()
     * @param string $name
     * @param array $parameters
     * @return PhpFile
     */
    public function addFunction(string $name, array $parameters = []): PhpFile
    {
        return $this->addFunctionElement(new PhpFunctionElement($name, $parameters));
    }
    /**
     * @param string $use
     * @param string $as
     * @param bool $last
     * @return PhpFile
     */
    public function addUse(string $use, string $as = null, bool $last = false): PhpFile
    {
        $expression = empty($as) ? "use %1\$s;%3\$s" : "use %1\$s as %2\$s;%3\$s";
        $this->mainElement->addChild(sprintf($expression, $use, $as, $last ? self::BREAK_LINE_CHAR : ''));
        return $this;
    }
    /**
     * @param string $namespace
     * @return PhpFile
     */
    public function setNamespace(string $namespace): PhpFile
    {
        $this->mainElement->addChild(sprintf("%2\$snamespace %s;%s", $namespace, self::BREAK_LINE_CHAR));
        return $this;
    }
}
