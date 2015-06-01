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
     */
    public function __construct($name)
    {
        parent::__construct($name);
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
     * @return string
     */
    public function getPhpDeclaration()
    {
        return sprintf('$%s = %s', parent::getPhpDeclaration(), var_export($this->getValue(), true));
    }
    /**
     * @return bool
     */
    public function hasSemicolon()
    {
        return true;
    }
    /**
     * @return bool
     */
    public function canBeAlone()
    {
        return true;
    }
}
