<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

class PhpVariable extends AbstractAssignedValueElement
{
    /**
     * returns the way the assignment is declared
     * @return string
     */
    public function getAssignmentDeclarator(): string
    {
        return '$';
    }
    /**
     * returns the way the value is assigned to the element
     * @returns string
     */
    public function getAssignmentSign(): string
    {
        return $this->hasValue() ? ' = ' : '';
    }
    /**
     * retutns the way the assignment is finished
     * @return string
     */
    public function getAssignmentFinishing(): string
    {
        return '';
    }
    /**
     * indicates if the element accepts non scalar value
     * @return bool
     */
    public function getAcceptNonScalarValue(): bool
    {
        return true;
    }
    /**
     * indicates if the current element has accessibility constraint
     * @return bool
     */
    public function hasAccessibilityConstraint(): bool
    {
        return false;
    }
    /**
     * defines authorized children element types
     * @return string[]
     */
    public function getChildrenTypes(): array
    {
        return [];
    }
    /**
     * indicates if the element finishes with a semicolon or not
     * @return bool
     */
    public function endsWithSemicolon(): bool
    {
        return true;
    }
}
