<?php

namespace WsdlToPhp\PhpGenerator\Component;

use WsdlToPhp\PhpGenerator\Element\PhpFile as PhpFileElement;
use WsdlToPhp\PhpGenerator\Component\PhpClass as PhpClassComponent;
use WsdlToPhp\PhpGenerator\Element\PhpVariable as PhpVariableElement;

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
     * @param PhpVariableElement $variable
     * @return AbstractComponent
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
     * @param PhpClassElement $class
     * @return PhpClass
     */
    public function addVariable($name, $value = null)
    {
        return $this->addVariableElement(new PhpVariableElement($name, $value));
    }
}
