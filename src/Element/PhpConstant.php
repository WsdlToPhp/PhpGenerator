<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

class PhpConstant extends AbstractElement implements AccessRestrictedElementInterface, AssignedValueElementInterface
{
    use AccessRestrictedElementTrait;
    use AssignedValueElementTrait;

    protected ?PhpClass $class;

    public function __construct(string $name, $value = null, ?PhpClass $class = null)
    {
        parent::__construct($name);
        $this->setValue($value);
        $this->setClass($class);
    }

    public function getPhpName(): string
    {
        if ($this->getClass() instanceof PhpClass) {
            return strtoupper(parent::getPhpName());
        }

        return parent::getPhpName();
    }

    public function setClass(?PhpClass $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getClass(): ?PhpClass
    {
        return $this->class;
    }

    public function getAssignmentDeclarator(): string
    {
        if ($this->getClass() instanceof PhpClass) {
            return 'const ';
        }

        return 'define(\'';
    }

    public function getAssignmentSign(): string
    {
        if ($this->getClass() instanceof PhpClass) {
            return ' = ';
        }

        return '\', ';
    }

    public function getAssignmentFinishing(): string
    {
        if ($this->getClass() instanceof PhpClass) {
            return '';
        }

        return ')';
    }

    public function getAcceptNonScalarValue(): bool
    {
        return false;
    }

    public function endsWithSemicolon(): bool
    {
        return true;
    }

    public function getChildrenTypes(): array
    {
        return [];
    }

    /**
     * Always return null to avoid having a literal string instead of quoted string.
     *
     * @param mixed $value
     */
    protected function getScalarValue($value)
    {
        return null;
    }
}
