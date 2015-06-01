<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpVariable extends AbstractAssignedValueElement
{
    /**
     * returns the way the assignment is declared
     * @return string
     */
    function getAssignmentDeclarator()
    {
        return '$';
    }
    /**
     * returns the way the value is assigned to the element
     * @returns string
    */
    function getAssignmentSign()
    {
        return ' = ';
    }
    /**
     * retutns the way the assignment is finished
     * @return string
    */
    function getAssignmentFinishing()
    {
        return '';
    }
    /**
     * indicates if the element accepts non scalar value
     * @return bool
     */
    function getAcceptNonScalarValue()
    {
        return true;
    }
}
