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
     * @param string $name
     * @param string $access
     * @param bool $final
     */
    public function __construct($name, $access = parent::ACCESS_PUBLIC, $static = false, $final = false)
    {
        parent::__construct($name, $access);
        $this->setFinal($final);
    }
    /**
     * @param bool $final
     * @throws \InvalidArgumentException
     * @return PhpMethod
     */
    public function setFinal($final)
    {
        if (!is_bool($final)) {
            throw new \InvalidArgumentException(sprintf('Final must be a boolean, "%s" given', gettype($final)));
        }
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
        if (!is_bool($static)) {
            throw new \InvalidArgumentException(sprintf('Static must be a boolean, "%s" given', gettype($static)));
        }
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
        return $this->getFinal() === true ? 'static ' : '';
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\AbstractAccessRestrictedElement::getPhpDeclaration()
     * @return string
     */
    public function getPhpDeclaration()
    {
        return sprintf('%s%s', $this->getPhpFinal(), parent::getPhpDeclaration());
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
}
