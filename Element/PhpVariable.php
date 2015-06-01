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
        return ' = ';
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
}
