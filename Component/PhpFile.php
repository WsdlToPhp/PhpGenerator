<?php

namespace WsdlToPhp\PhpGenerator\Component;

use WsdlToPhp\PhpGenerator\Element\PhpAnnotationBlock as PhpAnnotationBlockElement;
use WsdlToPhp\PhpGenerator\Element\PhpConstant as PhpConstantElement;
use WsdlToPhp\PhpGenerator\Element\PhpVariable as PhpVariableElement;
use WsdlToPhp\PhpGenerator\Element\PhpInterface as PhpInterfaceElement;
use WsdlToPhp\PhpGenerator\Element\PhpClass as PhpClassElement;
use WsdlToPhp\PhpGenerator\Element\PhpFile as PhpFileElement;
use WsdlToPhp\PhpGenerator\Component\PhpClass as PhpClassComponent;

class PhpFile extends AbstractComponent
{
    /**
     * @var PhpFileElement
     */
    protected $file;
    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->file = new PhpFileElement($name);
    }
    /**
     * @param PhpClassElement $class
     * @return PhpFile
     */
    public function addClassElement(PhpClassElement $class)
    {
        $this->file->addChild($class);
        return $this;
    }
    /**
     * @param PhpClassComponent $class
     * @return PhpFile
     */
    public function addClassComponent(PhpClassComponent $class)
    {
        $this->file->addChild($class->toString());
        return $this;
    }
    /**
     * @param PhpInterfaceElement $interface
     * @return PhpFile
     */
    public function addInterrfaceElement(PhpInterfaceElement $interface)
    {
        $this->file->addChild($interface);
        return $this;
    }
    /**
     * @param PhpVariableElement $variable
     * @return PhpFile
     */
    public function addVariableElement(PhpVariableElement $variable)
    {
        $this->file->addChild($variable);
        return $this;
    }
    /**
     * @param PhpConstantElement $constant
     * @return PhpFile
     */
    public function addConstantElement(PhpConstantElement $constant)
    {
        $this->file->addChild($constant);
        return $this;
    }
    /**
     * @param PhpAnnotationBlockElement $annotationBlock
     * @return PhpFile
     */
    public function addAnnotationBlock(PhpAnnotationBlockElement $annotationBlock)
    {
        $this->file->addChild($annotationBlock);
        return $this;
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Component\AbstractComponent::getElements()
     * @return AbstractElement[]|string[]
     */
    public function getElements()
    {
        return array(
            $this->file,
        );
    }
}
