<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

class PhpProperty extends PhpVariable
{
    /**
     * indicates if the current element has accessibility constraint
     * @return bool
     */
    public function hasAccessibilityConstraint(): bool
    {
        return true;
    }
}
