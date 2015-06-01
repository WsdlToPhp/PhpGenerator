<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpProperty extends PhpVariable
{
    /**
     * @return bool
     */
    public function canBeAlone()
    {
        return false;
    }
    /**
     * indicates if the current element has accessibility constraint
     * @return bool
     */
    public function hasAccessibilityConstraint()
    {
        return true;
    }
}
