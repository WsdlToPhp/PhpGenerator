<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

class PhpFunctionParameter extends PhpVariable implements TypeHintedElementInterface
{
    use TypeHintedElementTrait;

    public function __construct(string $name, $value = null, $type = null)
    {
        parent::__construct($name, $value);
        $this->setType($type);
    }

    public function getPhpDeclaration(): string
    {
        return sprintf('%s%s', $this->getPhpType(), parent::getPhpDeclaration());
    }

    public function endsWithSemicolon(): bool
    {
        return false;
    }

    protected function getAnyValue($value): string
    {
        if (is_array($value)) {
            return str_replace([self::BREAK_LINE_CHAR, ' '], '', parent::getAnyValue($value));
        }

        return parent::getAnyValue($value);
    }
}
