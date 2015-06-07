<?php

namespace WsdlToPhp\PhpGenerator\Component;

use WsdlToPhp\PhpGenerator\Element\PhpFile as PhpFileElement;
use WsdlToPhp\PhpGenerator\Component\PhpClass as PhpClassComponent;

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
}
