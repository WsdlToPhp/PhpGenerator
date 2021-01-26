<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

class PhpProperty extends PhpVariable
{
    public function hasAccessibilityConstraint(): bool
    {
        return true;
    }
}
