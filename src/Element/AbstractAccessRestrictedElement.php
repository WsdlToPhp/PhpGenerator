<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

use InvalidArgumentException;

abstract class AbstractAccessRestrictedElement extends AbstractElement
{
    const ACCESS_PRIVATE = 'private';

    const ACCESS_PROTECTED = 'protected';

    const ACCESS_PUBLIC = 'public';

    protected string $access;

    public function __construct(string $name, string $access = self::ACCESS_PUBLIC)
    {
        parent::__construct($name);
        $this->setAccess($access);
    }

    public function setAccess(string $access): AbstractElement
    {
        if (!static::accessIsValid($access)) {
            throw new InvalidArgumentException(sprintf('Access "%s" is invalid, please provide one of these accesses: %s', $access, implode(', ', self::getAccesses())));
        }
        $this->access = $access;

        return $this;
    }

    public function getAccess(): string
    {
        return $this->access;
    }

    public static function getAccesses(): array
    {
        return [
            self::ACCESS_PRIVATE,
            self::ACCESS_PROTECTED,
            self::ACCESS_PUBLIC,
        ];
    }

    public static function accessIsValid(?string $access): bool
    {
        return null === $access || in_array($access, self::getAccesses(), true);
    }

    /**
     * indicates if the current element has accessibility constraint.
     */
    abstract public function hasAccessibilityConstraint(): bool;

    protected function getPhpAccess(): string
    {
        if ($this->hasAccessibilityConstraint()) {
            return null === $this->getAccess() ? '' : sprintf('%s ', $this->getAccess());
        }

        return '';
    }
}
