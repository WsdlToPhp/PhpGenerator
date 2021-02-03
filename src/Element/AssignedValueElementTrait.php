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
        if (false === $this->getAcceptNonScalarValue() && !is_scalar($value) && null !== $value) {
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
            true === $this->endsWithSemicolon() ? ';' : '',
        ]);
    }

    protected function getFinalValue(): ?string
    {
        if (is_scalar($this->getValue()) && null !== ($scalarValue = $this->getScalarValue($this->getValue()))) {
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
        $exportedValue = var_export($value, true);
        // work around for known bug https://bugs.php.net/bug.php?id=66866
        if (is_float($value) && strlen((string) $value) !== strlen((string) $exportedValue)) {
            $exportedValue = (string) $value;
        }

        return $exportedValue;
    }
}
