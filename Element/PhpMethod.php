<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpMethod extends AbstractAccessRestrictedElement
{
    /**
     * @return bool
     */
    public function hasSemicolon()
    {
        return false;
    }
}
