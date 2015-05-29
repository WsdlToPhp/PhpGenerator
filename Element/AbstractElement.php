<?php

namespace WsdlTophp\PhpGenerator\Element;

abstract class AbstractElement implements GeneratableInterface
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->setName($name);
    }
    /**
     * @param string $name
     * @return AbstractElement
     */
    public function setName($name)
    {
        if (!self::nameIsValid($name)) {
            throw new \InvalidArgumentException(sprintf('Name "%s" is invalid, please provide a valid name', $name));
        }
        $this->name = $name;
        return $this;
    }
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param string $name
     * @return bool
     */
    public static function nameIsValid($name)
    {
        return preg_match('/[a-zA-Z]/', $name) === 1;
    }
    /**
     * @return string
     */
    public function toString()
    {

    }
    /**
     * @return string
     */
    final public function getPhpName()
    {
        return sprintf('$%s', $this->getName());
    }
    /**
     * @return string
     */
    protected function getPhpDeclaration()
    {
        return $this->getPhpName();
    }
}
