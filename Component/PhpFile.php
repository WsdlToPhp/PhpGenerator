<?php

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
    public function __construct($name)
    {
        $this->setMainElement(new PhpFileElement($name));
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Component\AbstractComponent::getElements()
     * @return PhpFileElement[]
     */
    public function getElements()
    {
        return array(
            $this->getMainElement(),
        );
    }
    /**
     * @param PhpClassComponent $class
     * @return PhpFile
     */
    public function addClassComponent(PhpClassComponent $class)
    {
        $this->mainElement->addChild($class->toString());
        return $this;
    }
    /**
     * @param PhpInterfaceComponent $interface
     * @return PhpFile
     */
    public function addInterfaceComponent(PhpInterfaceComponent $interface)
    {
        $this->mainElement->addChild($interface->toString());
        return $this;
    }
    /**
     * @param PhpVariableElement $variable
     * @return PhpFile
     */
    public function addVariableElement(PhpVariableElement $variable)
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
    public function addVariable($name, $value = null)
    {
        return $this->addVariableElement(new PhpVariableElement($name, $value));
    }
    /**
     * @param PhpFunctionElement $function
     * @return PhpFile
     */
    public function addFunctionElement(PhpFunctionElement $function)
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
    public function addFunction($name, array $parameters = array())
    {
        return $this->addFunctionElement(new PhpFunctionElement($name, $parameters));
    }
    /**
     * @param string $use
     * @param string $as
     * @param bool $last
     * @return PhpFile
     */
    public function addUse($use, $as = null, $last = false)
    {
        $expression = empty($as) ? "use %1\$s;%3\$s" : "use %1\$s as %2\$s;%3\$s";
        $this->mainElement->addChild(sprintf($expression, $use, $as, $last ? self::BREAK_LINE_CHAR : ''));
        return $this;
    }
    /**
     * @param string $namespace
     * @return PhpFile
     */
    public function setNamespace($namespace)
    {
        $this->mainElement->addChild(sprintf("%2\$snamespace %s;%s", $namespace, self::BREAK_LINE_CHAR));
        return $this;
    }
}
