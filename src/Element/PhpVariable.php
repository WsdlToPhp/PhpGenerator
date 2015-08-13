<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpVariable extends AbstractAssignedValueElement
{
    /**
     * returns the way the assignment is declared
     * @return string
     */
    public function getAssignmentDeclarator()
    {
        return '$';
    }
    /**
     * returns the way the value is assigned to the element
     * @returns string
     */
    public function getAssignmentSign()
    {
        return $this->hasValue() ? ' = ' : '';
    }
    /**
     * retutns the way the assignment is finished
     * @return string
     */
    public function getAssignmentFinishing()
    {
        return '';
    }
    /**
     * indicates if the element accepts non scalar value
     * @return bool
     */
    public function getAcceptNonScalarValue()
    {
        return true;
    }
    /**
     * indicates if the current element has accessibility constraint
     * @return bool
     */
    public function hasAccessibilityConstraint()
    {
        return false;
    }
    /**
     * defines authorized children element types
     * @return string[]
     */
    public function getChildrenTypes()
    {
        return array();
    }
    /**
     * indicates if the element finishes with a semicolon or not
     * @return bool
     */
    public function endsWithSemicolon()
    {
        return true;
    }
}
