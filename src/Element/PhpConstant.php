<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpConstant extends AbstractAssignedValueElement
{
    /**
     * @var PhpClass
     */
    protected $class;
    /**
     * @param string $name
     * @param mixed $value
     * @param PhpClass $class
     */
    public function __construct($name, $value = null, PhpClass $class = null)
    {
        parent::__construct($name, $value);
        $this->setValue($value);
        $this->setClass($class);
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\AbstractElement::getName()
     * @return string
     */
    public function getPhpName()
    {
        if ($this->getClass() instanceof PhpClass) {
            return strtoupper(parent::getPhpName());
        }
        return parent::getPhpName();
    }
    /**
     * @param PhpClass $class
     * @return PhpConstant
     */
    public function setClass(PhpClass $class = null)
    {
        $this->class = $class;
        return $this;
    }
    /**
     * @return PhpClass
     */
    public function getClass()
    {
        return $this->class;
    }
    /**
     * returns the way the assignment is declared
     * @return string
     */
    public function getAssignmentDeclarator()
    {
        if ($this->getClass() instanceof PhpClass) {
            return 'const ';
        }
        return 'define(\'';
    }
    /**
     * returns the way the value is assigned to the element
     * @return string
     */
    public function getAssignmentSign()
    {
        if ($this->getClass() instanceof PhpClass) {
            return ' = ';
        }
        return '\', ';
    }
    /**
     * retutns the way the assignment is finished
     * @return string
     */
    public function getAssignmentFinishing()
    {
        if ($this->getClass() instanceof PhpClass) {
            return '';
        }
        return ')';
    }
    /**
     * indicates if the element accepts non scalar value
     * @return bool
     */
    public function getAcceptNonScalarValue()
    {
        return false;
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
     * indicates if the element finishes with a semicolon or not
     * @return bool
     */
    public function endsWithSemicolon()
    {
        return true;
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
     * Always return null to avoid having value being detected as a potential function/method/variable
     * @see \WsdlToPhp\PhpGenerator\Element\AbstractAssignedValueElement::getScalarValue()
     */
    protected function getScalarValue($value)
    {
        return null;
    }
}
