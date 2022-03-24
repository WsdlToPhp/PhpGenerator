<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

use InvalidArgumentException;

class PhpDeclare extends AbstractElement
{
    public const STATEMENT = 'declare(%s);';

    public const DIRECTIVE_ENCODING = 'encoding';

    public const DIRECTIVE_STRICT_TYPES = 'strict_types';

    public const DIRECTIVE_TICKS = 'ticks';

    public const ALLOWED_DIRECTIVES = [
        self::DIRECTIVE_ENCODING,
        self::DIRECTIVE_STRICT_TYPES,
        self::DIRECTIVE_TICKS,
    ];

    /**
     * @var int|string
     */
    private $value;

    public function __construct(string $name, $value = null)
    {
        parent::__construct($name);
        $this->setValue($value);
    }

    /**
     * @param int|string $value
     */
    public function setValue($value): self
    {
        if (!is_null($value) && !is_scalar($value)) {
            throw new InvalidArgumentException(sprintf('Value must be a scalar value, %s given', var_export($value, true)));
        }

        $this->value = $value;

        return $this;
    }

    /**
     * @return int|string
     */
    public function getValue()
    {
        return $this->value;
    }

    public static function nameIsValid(string $name, bool $allowBackslash = false): bool
    {
        return parent::nameIsValid($name, $allowBackslash) && in_array($name, self::ALLOWED_DIRECTIVES, true);
    }

    public function getPhpDeclaration(): string
    {
        $directives = array_merge([$this], $this->getChildren());

        $strings = [];

        /** @var PhpDeclare $directive */
        foreach ($directives as $directive) {
            if (is_null($directive->getValue())) {
                continue;
            }

            $strings[] = sprintf('%s=%s', $directive->getName(), var_export($directive->getValue(), true));
        }

        return 0 === count($strings) ? '' : sprintf(self::STATEMENT, implode(', ', $strings));
    }

    public function addChild($child): AbstractElement
    {
        /** @var AbstractElement $child */
        if ($this->childIsValid($child) && $child->getName() === $this->getName()) {
            throw new InvalidArgumentException(sprintf('The current directive named %s can\'t contain a child of same directive name', $this->getName()));
        }

        return parent::addChild($child);
    }

    public function getChildrenTypes(): array
    {
        return [
            PhpDeclare::class,
        ];
    }

    /**
     * Children are handled before in getPhpDeclaration in order to have one line per declare directive.
     *
     * @param mixed $child
     */
    protected function getChildContent($child, int $indentation = null): string
    {
        return '';
    }
}
