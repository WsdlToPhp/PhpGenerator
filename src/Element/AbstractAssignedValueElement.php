<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

use InvalidArgumentException;

abstract class AbstractAssignedValueElement extends AbstractAccessRestrictedElement
{
    /**
     * Use this constant as value to ensure element has not assigned value
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
     * @throws InvalidArgumentException
     * @param mixed $value
     * @return AbstractAssignedValueElement
     */
    public function setValue($value): AbstractAssignedValueElement
    {
        if ($this->getAcceptNonScalarValue() === false && !is_scalar($value) && $value !== null) {
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
        return $this->getValue() !== self::NO_VALUE;
    }

    public function getPhpValue(): ?string
    {
        if (!$this->hasValue()) {
            return '';
        }
        return $this->getFinalValue();
    }

    protected function getFinalValue(): ?string
    {
        if (is_scalar($this->getValue()) && ($scalarValue = $this->getScalarValue($this->getValue())) !== null) {
            return $scalarValue;
        } elseif (is_null($this->getValue())) {
            return 'null';
        }
        return $this->getAnyValue($this->getValue());
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    protected function getScalarValue($value)
    {
        $scalarValue = null;
        if (stripos((string) $value, '::') === 0) {
            $scalarValue = substr($value, 2);
        } elseif (stripos((string) $value, '::') !== false || stripos((string) $value, 'new ') !== false || stripos((string) $value, '(') !== false || stripos((string) $value, ')') !== false) {
            $scalarValue = $value;
        }
        return $scalarValue;
    }

    /**
     * @param mixed $value
     * @return string
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

    public function getPhpDeclaration(): string
    {
        return sprintf('%s%s%s%s%s%s%s', $this->getPhpAccess(), $this->getAssignmentDeclarator(), $this->getPhpName(), $this->getAssignmentSign(), $this->getPhpValue(), $this->getAssignmentFinishing(), $this->endsWithSemicolon() === true ? ';' : '');
    }

    /**
     * returns the way the assignment is declared
     * @return string
     */
    abstract public function getAssignmentDeclarator(): string;

    /**
     * returns the way the value is assigned to the element
     * @returns string
     */
    abstract public function getAssignmentSign(): string;

    /**
     * returns the way the assignment is finished
     * @return string
     */
    abstract public function getAssignmentFinishing(): string;

    /**
     * indicates if the element accepts non scalar value
     * @return bool
     */
    abstract public function getAcceptNonScalarValue(): bool;

    /**
     * indicates if the element finishes with a semicolon or not
     * @return bool
     */
    abstract public function endsWithSemicolon(): bool;
}
