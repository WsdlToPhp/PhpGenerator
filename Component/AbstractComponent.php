<?php

namespace WsdlToPhp\PhpGenerator\Component;

use WsdlToPhp\PhpGenerator\Element\AbstractElement;

abstract class AbstractComponent implements GenerableInterface
{
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
     * @param string|AbstractElement $element
     * @throws \InvalidArgumentException
     * @return string
     */
    protected function getElementString($element)
    {
        if (is_scalar($element)) {
            return $element;
        } elseif ($element instanceof AbstractElement) {
            return $element->toString();
        } else {
            throw new \InvalidArgumentException(sprintf('Element of type "%s" can\'t be generated', gettype($element)));
        }
    }
}
