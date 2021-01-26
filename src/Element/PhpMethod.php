<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

class PhpMethod extends PhpFunction
{
    protected bool $final;

    protected bool $static;

    protected bool $abstract;

    protected bool $hasBody;

    /**
     * @param string $name
     * @param string[]|PhpFunctionParameter[] $parameters
     * @param string|null $returnType
     * @param string $access
     * @param bool $abstract
     * @param bool $static
     * @param bool $final
     * @param bool $hasBody
     */
    public function __construct(string $name, array $parameters = [], ?string $returnType = null, string $access = parent::ACCESS_PUBLIC, bool $abstract = false, bool $static = false, bool $final = false, bool $hasBody = true)
    {
        parent::__construct($name, $parameters, $returnType);
        $this
            ->setAbstract($abstract)
            ->setStatic($static)
            ->setFinal($final)
            ->setHasBody($hasBody)
            ->setAccess($access);
    }

    public function setAbstract(bool $abstract): self
    {
        $this->abstract = $abstract;

        return $this;
    }

    public function getAbstract(): bool
    {
        return $this->abstract;
    }

    protected function getPhpAbstract(): string
    {
        return $this->getAbstract() === true ? 'abstract ' : '';
    }

    public function setFinal(bool $final): self
    {
        $this->final = $final;

        return $this;
    }

    public function getFinal(): bool
    {
        return $this->final;
    }

    protected function getPhpFinal(): string
    {
        return $this->getFinal() === true ? 'final ' : '';
    }

    public function setStatic(bool $static): self
    {
        $this->static = $static;

        return $this;
    }

    public function getStatic(): bool
    {
        return $this->static;
    }

    protected function getPhpStatic(): string
    {
        return $this->getStatic() === true ? 'static ' : '';
    }

    public function setHasBody(bool $hasBody): self
    {
        $this->hasBody = $hasBody;

        return $this;
    }

    public function getHasBody(): bool
    {
        return $this->hasBody;
    }

    protected function getPhpReturnType(): string
    {
        return $this->getReturnType() ? sprintf(': %s', $this->getReturnType()) : '';
    }

    protected function getPhpDeclarationEnd(): string
    {
        return ($this->getHasBody() === false || $this->getAbstract() === true) ? ';' : '';
    }

    public function getPhpDeclaration(): string
    {
        return sprintf(
            '%s%s%s%sfunction %s(%s)%s%s',
            $this->getPhpFinal(),
            $this->getPhpAbstract(),
            $this->getPhpAccess(),
            $this->getPhpStatic(),
            $this->getPhpName(),
            $this->getPhpParameters(),
            $this->getPhpReturnType(),
            $this->getPhpDeclarationEnd()
        );
    }

    public function hasAccessibilityConstraint(): bool
    {
        return true;
    }

    /**
     * Allows to generate content before children content is generated
     * @param int|null $indentation
     * @return string
     */
    public function getLineBeforeChildren(?int $indentation = null): string
    {
        if ($this->getHasBody() === true) {
            return parent::getLineBeforeChildren($indentation);
        }

        return '';
    }

    /**
     * Allows to generate content after children content is generated
     * @param int|null $indentation
     * @return string
     */
    public function getLineAfterChildren(int $indentation = null): string
    {
        if ($this->getHasBody() === true) {
            return parent::getLineAfterChildren($indentation);
        }

        return '';
    }

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
