<?php

namespace WsdlToPhp\PhpGenerator\Component;

use WsdlToPhp\PhpGenerator\Element\AbstractElement;

abstract class AbstractComponent implements GenerableInterface
{
    /**
     * @see \WsdlToPhp\PhpGenerator\Component\GenerableInterface::toString()
     * @return string
     */
    public function toString()
    {
        $content = array();
        foreach ($this->getElements() as $element) {
            $content[] = $this->getElementString($element);
        }
        return implode('', $content);
    }
    /**
     * @return AbstractElement[]|string[]
     */
    abstract public function getElements();
    /**
     * @throws \InvalidArgumentException
     * @param string|AbstractElement $element
     * @return string
     */
    protected function getElementString($element)
    {
        if (is_scalar($element)) {
            return $element;
        } elseif ($element instanceof AbstractElement) {
            return $element->toString();
        }
        return '';
    }
}
