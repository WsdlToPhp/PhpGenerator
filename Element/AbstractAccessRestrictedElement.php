<?php

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
    public function __construct($name, $access = self::ACCESS_PUBLIC)
    {
        parent::__construct($name);
        $this->setAccess($access);
    }
    /**
     * @throws \InvalidArgumentException
     * @param string $access
     * @return AbstractElement
     */
    public function setAccess($access)
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
    public function getAccess()
    {
        return $this->access;
    }
    /**
     * @return string[]
     */
    public static function getAccesses()
    {
        return array(
            self::ACCESS_PRIVATE,
            self::ACCESS_PROTECTED,
            self::ACCESS_PUBLIC,
        );
    }
    /**
     * @param string $access
     * @return bool
     */
    public static function accessIsValid($access)
    {
        return $access === null || in_array($access, self::getAccesses(), true);
    }
    /**
     * @return string
     */
    protected function getPhpAccess()
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
    abstract public function hasAccessibilityConstraint();
}
