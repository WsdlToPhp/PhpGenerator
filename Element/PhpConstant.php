<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpConstant extends AbstractElement
{
    /**
     * @return bool
     */
    public function hasSemicolon()
    {
        return true;
    }
}
