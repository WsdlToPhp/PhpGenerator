<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpMethod extends AbstractAccessRestrictedElement
{
    /**
     * @var bool
     */
    protected $final;
    /**
     * @param string $name
     * @param string $access
     * @param bool $final
     */
    public function __construct($name, $access = parent::ACCESS_PUBLIC, $final = false)
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
     * @see \WsdlToPhp\PhpGenerator\Element\AbstractAccessRestrictedElement::getPhpDeclaration()
     * @return string
     */
    public function getPhpDeclaration()
    {
        return sprintf('%s%s', $this->getPhpFinal(), parent::getPhpDeclaration());
    }
    /**
     * @return bool
     */
    public function hasSemicolon()
    {
        return false;
    }
    /**
     * @return bool
     */
    public function canBeAlone()
    {
        return false;
    }
}
