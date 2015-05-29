<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpProperty extends AbstractAccessRestrictedElement
{
    /**
     * @var mixed
     */
    protected $defaultValue;
    /**
     * @param string $name
     * @param string $access
     * @param string $defaultValue
     */
    public function __construct($name, $access = null, $defaultValue = null)
    {
        parent::__construct($name, $access);
        $this->setDefaultValue($defaultValue);
    }
    /**
     * @param mixed $defaultValue
     * @return PhpProperty
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }
    /**
     * @return string
     */
    protected function getPhpDefaultValue()
    {
        return $this->getDefaultValue() === null ? '' : sprintf(' = %s', var_export($this->getDefaultValue(), true));
    }
    /**
     * @return string
     */
    protected function getPhpDeclaration()
    {
        return sprintf('%s%s', parent::getPhpDeclaration(), $this->getPhpDefaultValue());
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
        return false;
    }
}
