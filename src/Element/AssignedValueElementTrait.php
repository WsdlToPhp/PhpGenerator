<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

use InvalidArgumentException;

trait AssignedValueElementTrait
{
    /**
     * @var mixed
     */
    protected $value;

    public function setValue($value): AbstractElement
    {
        if (!$this->getAcceptNonScalarValue() && !is_scalar($value) && !is_null($value)) {
            throw new InvalidArgumentException(sprintf('Value of type "%s" is not a valid scalar value for %s object', gettype($value), $this->getCalledClass()));
        }
        $this->value = $value;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function hasValue(): bool
    {
        return AssignedValueElementInterface::NO_VALUE !== $this->getValue();
    }

    public function getPhpValue(): ?string
    {
        if (!$this->hasValue()) {
            return '';
        }

        return $this->getFinalValue();
    }

    public function getPhpDeclaration(): string
    {
        return implode('', [
            $this->getAssignmentDeclarator(),
            $this->getPhpName(),
            $this->getAssignmentSign(),
            $this->getPhpValue(),
            $this->getAssignmentFinishing(),
            $this->endsWithSemicolon() ? ';' : '',
        ]);
    }

    abstract public function endsWithSemicolon(): bool;

    abstract public function getAssignmentDeclarator(): string;

    abstract public function getAssignmentSign(): string;

    abstract public function getAssignmentFinishing(): string;

    abstract public function getAcceptNonScalarValue(): bool;

    abstract public function getCalledClass(): string;

    abstract public function getPhpName(): string;

    protected function getFinalValue(): ?string
    {
        if (is_scalar($this->getValue()) && !is_null($scalarValue = $this->getScalarValue($this->getValue()))) {
            return $scalarValue;
        }
        if (is_null($this->getValue())) {
            return 'null';
        }

        return $this->getAnyValue($this->getValue());
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    protected function getScalarValue($value)
    {
        $scalarValue = null;
        if (0 === stripos((string) $value, '::')) {
            $scalarValue = substr($value, 2);
        } elseif (false !== stripos((string) $value, '::') || false !== stripos((string) $value, 'new ') || false !== stripos((string) $value, '(') || false !== stripos((string) $value, ')')) {
            $scalarValue = $value;
        }

        return $scalarValue;
    }

    protected function getAnyValue($value): string
    {
        if (is_array($value)) {
            $exportedValue = empty($value) ? '[]' : implode("\n", array_map(function ($line) {
                return 'array (' === $line ? '[' : (')' === $line ? ']' : $line);
            }, explode("\n", var_export($value, true))));
        } else {
            $exportedValue = var_export($value, true);
        }

        // work around for known bug https://bugs.php.net/bug.php?id=66866
        if (is_float($value) && strlen((string) $value) !== strlen((string) $exportedValue)) {
            $exportedValue = (string) $value;
        }

        return $exportedValue;
    }
}
