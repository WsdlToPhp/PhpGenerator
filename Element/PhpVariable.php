<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpVariable extends AbstractElement
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
     * @return PhpVariable
     */
    public function setValue($value)
    {
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
        return sprintf('$%s = %s;', parent::getPhpDeclaration(), $this->getPhpValue());
    }
    /**
     * @return bool
     */
    public function canBeAlone()
    {
        return true;
    }
}
