<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

use InvalidArgumentException;

abstract class AbstractAssignedValueElement extends AbstractAccessRestrictedElement
{
    /**
     * Use this constant as value to ensure element has not assigned value.
     */
    const NO_VALUE = '##NO_VALUE##';

    /**
     * @var mixed
     */
    protected $value;

    public function __construct(string $name, $value = null, string $access = parent::ACCESS_PUBLIC)
    {
        parent::__construct($name, $access);
        $this->setValue($value);
    }

    /**
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     */
    public function setValue($value): AbstractAssignedValueElement
    {
        if (false === $this->getAcceptNonScalarValue() && !is_scalar($value) && null !== $value) {
            throw new InvalidArgumentException(sprintf('Value of type "%s" is not a valid scalar value for %s object', gettype($value), $this->getCalledClass()));
        }
        $this->value = $value;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    public function hasValue(): bool
    {
        return self::NO_VALUE !== $this->getValue();
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
        return sprintf('%s%s%s%s%s%s%s', $this->getPhpAccess(), $this->getAssignmentDeclarator(), $this->getPhpName(), $this->getAssignmentSign(), $this->getPhpValue(), $this->getAssignmentFinishing(), true === $this->endsWithSemicolon() ? ';' : '');
    }

    /**
     * returns the way the assignment is declared.
     */
    abstract public function getAssignmentDeclarator(): string;

    /**
     * returns the way the value is assigned to the element.
     *
     * @returns string
     */
    abstract public function getAssignmentSign(): string;

    /**
     * returns the way the assignment is finished.
     */
    abstract public function getAssignmentFinishing(): string;

    /**
     * indicates if the element accepts non scalar value.
     */
    abstract public function getAcceptNonScalarValue(): bool;

    /**
     * indicates if the element finishes with a semicolon or not.
     */
    abstract public function endsWithSemicolon(): bool;

    protected function getFinalValue(): ?string
    {
        if (is_scalar($this->getValue()) && ($scalarValue = $this->getScalarValue($this->getValue())) !== null) {
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

    /**
     * @param mixed $value
     */
    protected function getAnyValue($value): string
    {
        $exportedValue = var_export($value, true);
        // work around for known bug https://bugs.php.net/bug.php?id=66866
        if (is_float($value) && strlen((string) $value) !== strlen((string) $exportedValue)) {
            $exportedValue = substr($exportedValue, 0, strlen($value));
        }

        return $exportedValue;
    }
}
