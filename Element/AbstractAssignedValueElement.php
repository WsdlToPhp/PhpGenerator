<?php

namespace WsdlToPhp\PhpGenerator\Element;

abstract class AbstractAssignedValueElement extends AbstractAccessRestrictedElement
{
    /**
     * Use this constant as value to ensure element has not assigned value
     * @var unknown
     */
    const NO_VALUE = '##NO_VALUE##';
    /**
     * @var mixed
     */
    protected $value;
    /**
     * @param string $name
     * @param mixed $value
     * @param string $access
     */
    public function __construct($name, $value = null, $access = parent::ACCESS_PUBLIC)
    {
        parent::__construct($name, $access);
        $this->setValue($value);
    }
    /**
     * @param mixed $value
     * @throws \InvalidArgumentException
     * @return AbstractAssignedValueElement
     */
    public function setValue($value)
    {
        if ($this->getAcceptNonScalarValue() === false && !is_scalar($value) && $value !== null) {
            throw new \InvalidArgumentException(sprintf('Value of type "%s" is not a valid scalar value', gettype($value)));
        }
        $this->value = $value;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
    /**
     * @return bool
     */
    public function hasValue()
    {
        return $this->getValue() !== self::NO_VALUE;
    }
    /**
     * @return mixed
     */
    public function getPhpValue()
    {
        if (!$this->hasValue()) {
            return '';
        }
        return $this->getFinalValue();
    }
    /**
     * @return string|mixed
     */
    protected function getFinalValue()
    {
        if (is_scalar($this->getValue())) {
            if (stripos($this->getValue(), '::') === 0) {
                return substr($this->getValue(), 2);
            } elseif (stripos($this->getValue(), '::') !== false || stripos($this->getValue(), 'new') !== false || stripos($this->getValue(), '(') !== false || stripos($this->getValue(), ')') !== false) {
                return $this->getValue();
            }
        } elseif (is_null($this->getValue())) {
            return 'null';
        }
        return var_export($this->getValue(), true);
    }
    /**
     * @return string
     */
    public function getPhpDeclaration()
    {
        return sprintf('%s%s%s%s%s%s%s', $this->getPhpAccess(), $this->getAssignmentDeclarator(), $this->getPhpName(), $this->getAssignmentSign(), $this->getPhpValue(), $this->getAssignmentFinishing(), $this->endsWithSemicolon() === true ? ';' : '');
    }
    /**
     * returns the way the assignment is declared
     * @return string
     */
    abstract public function getAssignmentDeclarator();
    /**
     * returns the way the value is assigned to the element
     * @returns string
     */
    abstract public function getAssignmentSign();
    /**
     * returns the way the assignment is finished
     * @return string
     */
    abstract public function getAssignmentFinishing();
    /**
     * indicates if the element accepts non scalar value
     * @return bool
     */
    abstract public function getAcceptNonScalarValue();
    /**
     * indicates if the element finishes with a semicolon or not
     * @return bool
     */
    abstract public function endsWithSemicolon();
}
