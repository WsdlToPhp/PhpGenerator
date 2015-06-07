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
     * @var bool
     */
    protected $hasBody;
    /**
     * @param string $name
     * @param string[]|PhpFunctionParameter[] $parameters
     * @param string $access
     * @param bool $abstract
     * @param bool $static
     * @param bool $final
     * @param bool $hasBody
     */
    public function __construct($name, array $parameters = array(), $access = parent::ACCESS_PUBLIC, $abstract = false, $static = false, $final = false, $hasBody = true)
    {
        parent::__construct($name, $parameters);
        $this->setAccess($access);
        $this->setAbstract($abstract);
        $this->setStatic($static);
        $this->setFinal($final);
        $this->setHasBody($hasBody);
    }
    /**
     * @throws \InvalidArgumentException
     * @param bool $abstract
     * @return PhpMethod
     */
    public function setAbstract($abstract)
    {
        self::checkBooleanWithException('abstract', $abstract);
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
     * @throws \InvalidArgumentException
     * @param bool $final
     * @return PhpMethod
     */
    public function setFinal($final)
    {
        self::checkBooleanWithException('final', $final);
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
     * @throws \InvalidArgumentException
     * @param bool $static
     * @return PhpMethod
     */
    public function setStatic($static)
    {
        self::checkBooleanWithException('static', $static);
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
     * @throws \InvalidArgumentException
     * @param bool $hasBody
     * @return PhpMethod
     */
    public function setHasBody($hasBody)
    {
        self::checkBooleanWithException('hasBody', $hasBody);
        $this->hasBody = $hasBody;
        return $this;
    }
    /**
     * @return bool
     */
    public function getHasBody()
    {
        return $this->hasBody;
    }
    /**
     * @return string
     */
    protected function getPhpDeclarationEnd()
    {
        return ($this->getHasBody() === false || $this->getAbstract() === true) ? ';' : '';
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\AbstractAccessRestrictedElement::getPhpDeclaration()
     * @return string
     */
    public function getPhpDeclaration()
    {
        return sprintf('%s%s%s%sfunction %s(%s)%s', $this->getPhpFinal(), $this->getPhpAbstract(), $this->getPhpAccess(), $this->getPhpStatic(), $this->getPhpName(), $this->getPhpParameters(), $this->getPhpDeclarationEnd());
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
     * @throws \InvalidArgumentException
     * @param string $propertyName
     * @param bool $value
     */
    public static function checkBooleanWithException($propertyName, $value)
    {
        if (!is_bool($value)) {
            throw new \InvalidArgumentException(sprintf('%s must be a boolean, "%s" given', $propertyName, gettype($value)));
        }
    }
    /**
     * Allows to generate content before children content is generated
     * @param int $indentation
     * @return string
     */
    public function getLineBeforeChildren($indentation = null)
    {
        if ($this->getHasBody() === true) {
            return parent::getLineBeforeChildren($indentation);
        }
        return '';
    }
    /**
     * Allows to generate content after children content is generated
     * @param int $indentation
     * @return string
     */
    public function getLineAfterChildren($indentation = null)
    {
        if ($this->getHasBody() === true) {
            return parent::getLineAfterChildren($indentation);
        }
        return '';
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\AbstractElement::getChildren()
     * @return array
     */
    public function getChildren()
    {
        if ($this->getHasBody() === true) {
            return parent::getChildren();
        }
        return array();
    }
    /**
     * Allows to indicate that children are contained by brackets,
     * in the case the method returns true, getBracketBeforeChildren
     * is called instead of getLineBeforeChildren and getBracketAfterChildren
     * is called instead of getLineAfterChildren, but be aware that these methods
     * call the two others
     * @return bool
     */
    public function useBracketsForChildren()
    {
        return $this->getHasBody();
    }
}
