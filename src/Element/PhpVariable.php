<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

class PhpVariable extends AbstractElement implements AssignedValueElementInterface
{
    use AssignedValueElementTrait;

    public function __construct(string $name, $value = null)
    {
        parent::__construct($name);
        $this->setValue($value);
    }

    public function getAssignmentDeclarator(): string
    {
        return '$';
    }

    public function getAssignmentSign(): string
    {
        return $this->hasValue() ? ' = ' : '';
    }

    public function getAssignmentFinishing(): string
    {
        return '';
    }

    public function getAcceptNonScalarValue(): bool
    {
        return true;
    }

    public function getChildrenTypes(): array
    {
        return [];
    }

    public function endsWithSemicolon(): bool
    {
        return true;
    }
}
