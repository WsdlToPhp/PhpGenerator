<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpInterface extends PhpClass
{
    /**
     * @var string
     */
    const PHP_DECLARATION = 'interface';
    /**
     * @var string
     */
    const PHP_IMPLEMENTS_KEYWORD = 'extends';
    /**
     * An interface is never abstract
     * @return bool
     */
    public function getAbstract()
    {
        return false;
    }
    /**
     * An interface never implements, it extends,
     * so we use interfaces property to store this information (tricky indeed)
     * @return null
     */
    public function getExtends()
    {
        return null;
    }
    /**
     * defines authorized children element types
     * @return string[]
     */
    public function getChildrenTypes()
    {
        return array(
            'string',
            'WsdlToPhp\\PhpGenerator\\Element\\PhpAnnotationBlock',
            'WsdlToPhp\\PhpGenerator\\Element\\PhpMethod',
            'WsdlToPhp\\PhpGenerator\\Element\\PhpConstant',
        );
    }
    /**
     * ensure method has no body
     * @see \WsdlToPhp\PhpGenerator\Element\AbstractElement::addChild()
     * @param mixed
     */
    public function addChild($child)
    {
        if ($child instanceof PhpMethod) {
            $child->setHasBody(false);
        }
        return parent::addChild($child);
    }
}
