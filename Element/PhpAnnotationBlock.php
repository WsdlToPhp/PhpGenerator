<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpAnnotationBlock extends AbstractElement
{
    /**
     * @return bool
     */
    public function canBeAlone()
    {
        return true;
    }
}
