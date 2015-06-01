<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpConstant extends AbstractElement
{
    /**
     * @return bool
     */
    public function canBeAlone()
    {
        return true;
    }
}
