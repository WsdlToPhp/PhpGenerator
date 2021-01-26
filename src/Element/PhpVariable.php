<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

class PhpVariable extends AbstractAssignedValueElement
{
    public function getAssignmentDeclarator(): string
    {
        return '$';
    }

    public function getAssignmentSign(): string
    {
        return $this->hasValue() ? ' = ' : '';
    }

    public function getAssignmentFinishing(): string
    {
        return '';
    }

    public function getAcceptNonScalarValue(): bool
    {
        return true;
    }

    public function hasAccessibilityConstraint(): bool
    {
        return false;
    }

    public function getChildrenTypes(): array
    {
        return [];
    }

    public function endsWithSemicolon(): bool
    {
        return true;
    }
}
