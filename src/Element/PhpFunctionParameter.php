<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

use InvalidArgumentException;

class PhpFunctionParameter extends PhpVariable
{
    /**
     * @var string|PhpClass
     */
    protected $type;

    public function __construct(string $name, $value = null, $type = null)
    {
        parent::__construct($name, $value);
        $this->setType($type);
    }

    /**
     * @throws InvalidArgumentException
     * @param string|PhpClass $type
     * @return PhpFunctionParameter
     */
    public function setType($type): self
    {
        if (!static::typeIsValid($type)) {
            throw new InvalidArgumentException(sprintf('Type "%s" is not valid', gettype($type)));
        }
        $this->type = $type;
        return $this;
    }

    /**
     * @param string|PhpClass $type
     * @return bool
     */
    public static function typeIsValid($type): bool
    {
        return $type === null || static::stringIsValid($type, true, true) || $type instanceof PhpClass;
    }

    /**
     * @return string|PhpClass
     */
    public function getType()
    {
        return $this->type;
    }

    protected function getPhpType(): string
    {
        $type = $this->getType();
        return empty($type) ? '' : sprintf('%s ', $type instanceof PhpClass ? $type->getPhpName() : $type);
    }

    public function getPhpDeclaration(): string
    {
        return sprintf('%s%s', $this->getPhpType(), parent::getPhpDeclaration());
    }

    public function getAssignmentSign(): string
    {
        return $this->hasValue() ? ' = ' : '';
    }

    public function endsWithSemicolon(): bool
    {
        return false;
    }

    protected function getAnyValue($value): string
    {
        if (is_array($value)) {
            return str_replace([self::BREAK_LINE_CHAR, ' '], '', var_export($value, true));
        }
        return parent::getAnyValue($value);
    }
}
