<?php

declare(strict_types=1);

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
    public function __construct(string $name, $value = null, PhpClass $class = null)
    {
        parent::__construct($name, $value);
        $this
            ->setValue($value)
            ->setClass($class);
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\AbstractElement::getName()
     * @return string
     */
    public function getPhpName(): string
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
    public function setClass(PhpClass $class = null): PhpConstant
    {
        $this->class = $class;
        return $this;
    }
    /**
     * @return PhpClass
     */
    public function getClass(): ?PhpClass
    {
        return $this->class;
    }
    /**
     * returns the way the assignment is declared
     * @return string
     */
    public function getAssignmentDeclarator(): string
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
    public function getAssignmentSign(): string
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
    public function getAssignmentFinishing(): string
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
    public function getAcceptNonScalarValue(): bool
    {
        return false;
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
     * indicates if the element finishes with a semicolon or not
     * @return bool
     */
    public function endsWithSemicolon(): bool
    {
        return true;
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
     * Always return null to avoid having value being detected as a potential function/method/variable
     * @see \WsdlToPhp\PhpGenerator\Element\AbstractAssignedValueElement::getScalarValue()
     */
    protected function getScalarValue($value)
    {
        return null;
    }
}
