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
     * @throws \InvalidArgumentException
     * @param mixed $value
     * @return AbstractAssignedValueElement
     */
    public function setValue($value)
    {
        if ($this->getAcceptNonScalarValue() === false && !is_scalar($value) && $value !== null) {
            throw new \InvalidArgumentException(sprintf('Value of type "%s" is not a valid scalar value for %s object', gettype($value), $this->getCalledClass()));
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
     * @return mixed
     */
    protected function getFinalValue()
    {
        if (is_scalar($this->getValue()) && ($scalarValue = $this->getScalarValue($this->getValue())) !== null) {
            return $scalarValue;
        } elseif (is_null($this->getValue())) {
            return 'null';
        }
        return $this->getAnyValue($this->getValue());
    }
    /**
     * @param mixed $value
     * @return mixed
     */
    protected function getScalarValue($value)
    {
        $scalarValue = null;
        if (stripos($value, '::') === 0) {
            $scalarValue = substr($value, 2);
        } elseif (stripos($value, '::') !== false || stripos($value, 'new ') !== false || stripos($value, '(') !== false || stripos($value, ')') !== false) {
            $scalarValue = $value;
        }
        return $scalarValue;
    }
    /**
     * @param mixed $value
     * @return string
     */
    protected function getAnyValue($value)
    {
        $exportedValue = var_export($value, true);
        // work around for known bug https://bugs.php.net/bug.php?id=66866
        if (is_float($value) && strlen($value) !== strlen($exportedValue)) {
            $exportedValue = substr($exportedValue, 0, strlen($value));
        }
        return $exportedValue;
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
