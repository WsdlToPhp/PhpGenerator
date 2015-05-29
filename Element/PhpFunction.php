<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpFunction
{
    /**
     * @return bool
     */
    public function hasSemicolon()
    {
        return false;
    }
    /**
     * @return bool
     */
    public function canBeAlone()
    {
        return true;
    }
}
