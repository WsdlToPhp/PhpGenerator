<?php

namespace WsdlToPhp\PhpGenerator\Element;

abstract class AbstractAssignedValueElement extends AbstractElement
{
    /**
     * @var mixed
     */
    protected $value;
    /**
     * @param string $name
     * @param mixed $value
     */
    public function __construct($name, $value = null)
    {
        parent::__construct($name);
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
     * @return mixed
     */
    public function getPhpValue()
    {
        if (is_scalar($this->getValue()) && (stripos($this->getValue(), '::') !== false || stripos($this->getValue(), 'new') !== false || stripos($this->getValue(), '(') !== false || stripos($this->getValue(), ')') !== false)) {
            return $this->getValue();
        }
        return var_export($this->getValue(), true);
    }
    /**
     * @return string
     */
    public function getPhpDeclaration()
    {
        return sprintf('%s%s%s%s%s;', $this->getAssignmentDeclarator(), parent::getPhpDeclaration(), $this->getAssignmentSign(), $this->getPhpValue(), $this->getAssignmentFinishing());
    }
    /**
     * returns the way the assignment is declared
     * @return string
     */
    abstract function getAssignmentDeclarator();
    /**
     * returns the way the value is assigned to the element
     * @returns string
     */
    abstract function getAssignmentSign();
    /**
     * returns the way the assignment is finished
     * @return string
     */
    abstract function getAssignmentFinishing();
    /**
     * indicates if the element accepts non scalar value
     * @return bool
     */
    abstract function getAcceptNonScalarValue();
    /**
     * @return bool
     */
    public function canBeAlone()
    {
        return true;
    }
}
