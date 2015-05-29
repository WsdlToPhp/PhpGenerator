<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpAnnotationBlock extends AbstractElement
{
    /**
     * @return bool
     */
    public function hasSemicolon()
    {
        return false;
    }
}
