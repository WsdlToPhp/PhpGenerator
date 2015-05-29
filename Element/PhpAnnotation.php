<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpAnnotation extends AbstractElement
{
    /**
     * @return bool
     */
    public function hasSemicolon()
    {
        return false;
    }
}
