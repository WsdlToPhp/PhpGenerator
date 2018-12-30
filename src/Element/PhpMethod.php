<?php

declare(strict_types=1);

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
    public function __construct(string $name, array $parameters = [], string $access = parent::ACCESS_PUBLIC, bool $abstract = false, bool $static = false, bool $final = false, bool $hasBody = true)
    {
        parent::__construct($name, $parameters);
        $this
            ->setAccess($access)
            ->setAbstract($abstract)
            ->setStatic($static)
            ->setFinal($final)
            ->setHasBody($hasBody);
    }
    /**
     * @param bool $abstract
     * @return PhpMethod
     */
    public function setAbstract(bool $abstract): PhpMethod
    {
        $this->abstract = $abstract;
        return $this;
    }
    /**
     * @return bool
     */
    public function getAbstract(): bool
    {
        return $this->abstract;
    }
    /**
     * @return string
     */
    protected function getPhpAbstract(): string
    {
        return $this->getAbstract() === true ? 'abstract ' : '';
    }
    /**
     * @param bool $final
     * @return PhpMethod
     */
    public function setFinal(bool $final): PhpMethod
    {
        $this->final = $final;
        return $this;
    }
    /**
     * @return bool
     */
    public function getFinal(): bool
    {
        return $this->final;
    }
    /**
     * @return string
     */
    protected function getPhpFinal(): string
    {
        return $this->getFinal() === true ? 'final ' : '';
    }
    /**
     * @param bool $static
     * @return PhpMethod
     */
    public function setStatic(bool $static): PhpMethod
    {
        $this->static = $static;
        return $this;
    }
    /**
     * @return bool
     */
    public function getStatic(): bool
    {
        return $this->static;
    }
    /**
     * @return string
     */
    protected function getPhpStatic(): string
    {
        return $this->getStatic() === true ? 'static ' : '';
    }
    /**
     * @param bool $hasBody
     * @return PhpMethod
     */
    public function setHasBody(bool $hasBody): PhpMethod
    {
        $this->hasBody = $hasBody;
        return $this;
    }
    /**
     * @return bool
     */
    public function getHasBody(): bool
    {
        return $this->hasBody;
    }
    /**
     * @return string
     */
    protected function getPhpDeclarationEnd(): string
    {
        return ($this->getHasBody() === false || $this->getAbstract() === true) ? ';' : '';
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\AbstractAccessRestrictedElement::getPhpDeclaration()
     * @return string
     */
    public function getPhpDeclaration(): string
    {
        return sprintf('%s%s%s%sfunction %s(%s)%s', $this->getPhpFinal(), $this->getPhpAbstract(), $this->getPhpAccess(), $this->getPhpStatic(), $this->getPhpName(), $this->getPhpParameters(), $this->getPhpDeclarationEnd());
    }
    /**
     * indicates if the current element has accessibility constraint
     * @return bool
     */
    public function hasAccessibilityConstraint(): bool
    {
        return true;
    }
    /**
     * Allows to generate content before children content is generated
     * @param int $indentation
     * @return string
     */
    public function getLineBeforeChildren(int $indentation = null): string
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
    public function getLineAfterChildren(int $indentation = null): string
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
    public function getChildren(): array
    {
        if ($this->getHasBody() === true) {
            return parent::getChildren();
        }
        return [];
    }
    /**
     * Allows to indicate that children are contained by brackets,
     * in the case the method returns true, getBracketBeforeChildren
     * is called instead of getLineBeforeChildren and getBracketAfterChildren
     * is called instead of getLineAfterChildren, but be aware that these methods
     * call the two others
     * @return bool
     */
    public function useBracketsForChildren(): bool
    {
        return $this->getHasBody();
    }
}
