<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpMethod extends PhpFunction
{
    /**
     * @var bool
     */
    protected $final;
    /**
     * @var bool
     */
    protected $static;
    /**
     * @var bool
     */
    protected $abstract;
    /**
     * @param string $name
     * @param string $access
     * @param string[]|PhpFunctionParameter[] $parameters
     * @param bool $abstract
     * @param bool $static
     * @param bool $final
     */
    public function __construct($name, $access = parent::ACCESS_PUBLIC, array $parameters = array(), $abstract = false, $static = false, $final = false)
    {
        parent::__construct($name, $access, $parameters);
        $this->setAbstract($abstract);
        $this->setStatic($static);
        $this->setFinal($final);
    }
    /**
     * @param bool $abstract
     * @throws \InvalidArgumentException
     * @return PhpMethod
     */
    public function setAbstract($abstract)
    {
        self::checkBooleanWithException($abstract);
        $this->abstract = $abstract;
        return $this;
    }
    /**
     * @return bool
     */
    public function getAbstract()
    {
        return $this->abstract;
    }
    /**
     * @return string
     */
    protected function getPhpAbstract()
    {
        return $this->getAbstract() === true ? 'abstract ' : '';
    }
    /**
     * @param bool $abstract
     * @throws \InvalidArgumentException
     * @return PhpMethod
     */
    public function setFinal($final)
    {
        self::checkBooleanWithException($final);
        $this->final = $final;
        return $this;
    }
    /**
     * @return bool
     */
    public function getFinal()
    {
        return $this->final;
    }
    /**
     * @return string
     */
    protected function getPhpFinal()
    {
        return $this->getFinal() === true ? 'final ' : '';
    }
    /**
     * @param bool $static
     * @throws \InvalidArgumentException
     * @return PhpMethod
     */
    public function setStatic($static)
    {
        self::checkBooleanWithException($static);
        $this->static = $static;
        return $this;
    }
    /**
     * @return bool
     */
    public function getStatic()
    {
        return $this->static;
    }
    /**
     * @return string
     */
    protected function getPhpStatic()
    {
        return $this->getStatic() === true ? 'static ' : '';
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\AbstractAccessRestrictedElement::getPhpDeclaration()
     * @return string
     */
    public function getPhpDeclaration()
    {
        return sprintf('%s%s%s%sfunction %s(%s)%s', $this->getPhpFinal(), $this->getPhpAbstract(), $this->getPhpAccess(), $this->getPhpStatic(), $this->getPhpName(), $this->getPhpParameters(), $this->getAbstract() === true ? ';' : '');
    }
    /**
     * indicates if the current element has accessibility constraint
     * @return bool
     */
    public function hasAccessibilityConstraint()
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
    /**
     * @param bool $value
     * @throws \InvalidArgumentException
     */
    public static function checkBooleanWithException($value)
    {
        if (!is_bool($value)) {
            throw new \InvalidArgumentException(sprintf('Static must be a boolean, "%s" given', gettype($value)));
        }
    }
}
