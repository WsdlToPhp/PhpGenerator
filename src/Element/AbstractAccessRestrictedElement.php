<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

abstract class AbstractAccessRestrictedElement extends AbstractElement
{
    /**
     * @var string
     */
    const ACCESS_PRIVATE = 'private';
    /**
     * @var string
     */
    const ACCESS_PROTECTED = 'protected';
    /**
     * @var string
     */
    const ACCESS_PUBLIC = 'public';
    /**
     * @var string
     */
    protected $access;
    /**
     * @param string $name
     * @param string $access
     */
    public function __construct(string $name, string $access = self::ACCESS_PUBLIC)
    {
        parent::__construct($name);
        $this->setAccess($access);
    }
    /**
     * @throws \InvalidArgumentException
     * @param string $access
     * @return AbstractElement
     */
    public function setAccess(string $access): AbstractElement
    {
        if (!self::accessIsValid($access)) {
            throw new \InvalidArgumentException(sprintf('Access "%s" is invalid, please provide one of these accesses: %s', $access, implode(', ', self::getAccesses())));
        }
        $this->access = $access;
        return $this;
    }
    /**
     * @return string
     */
    public function getAccess(): string
    {
        return $this->access;
    }
    /**
     * @return string[]
     */
    public static function getAccesses(): array
    {
        return [
            self::ACCESS_PRIVATE,
            self::ACCESS_PROTECTED,
            self::ACCESS_PUBLIC,
        ];
    }
    /**
     * @param string $access
     * @return bool
     */
    public static function accessIsValid(?string $access): bool
    {
        return $access === null || in_array($access, self::getAccesses(), true);
    }
    /**
     * @return string
     */
    protected function getPhpAccess(): string
    {
        if ($this->hasAccessibilityConstraint()) {
            return $this->getAccess() === null ? '' : sprintf('%s ', $this->getAccess());
        }
        return '';
    }
    /**
     * indicates if the current element has accessibility constraint
     * @return bool
     */
    abstract public function hasAccessibilityConstraint(): bool;
}
