<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpVariable extends AbstractElement
{
    /**
     * @return bool
     */
    public function hasSemicolon()
    {
        return true;
    }
}
