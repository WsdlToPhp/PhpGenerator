<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpClass extends AbstractElement
{
    /**
     * @var string
     */
    const PHP_DECLARATION = 'class';
    /**
     * @var string
     */
    const PHP_ABSTRACT_KEYWORD = 'abstract';
    /**
     * @var string
     */
    const PHP_IMPLEMENTS_KEYWORD = 'implements';
    /**
     * @var string
     */
    const PHP_EXTENDS_KEYWORD = 'extends';
    /**
     * @var bool
     */
    protected $abstract;
    /**
     * @var string|PhpClass
     */
    protected $extends;
    /**
     * @var string[]|PhpClass[]
     */
    protected $interfaces;
    /**
     * @param string $name
     * @param bool $abstract
     * @param string|PhpClass|null $extends
     * @param string[]|PhpClass[] $interfaces
     */
    public function __construct($name, $abstract = false, $extends = null, array $interfaces = array())
    {
        parent::__construct($name);
        $this->setAbstract($abstract);
        $this->setExtends($extends);
        $this->setInterfaces($interfaces);
    }
    /**
     * @throws \InvalidArgumentException
     * @param bool $abstract
     * @return PhpClass
     */
    public function setAbstract($abstract)
    {
        if (!is_bool($abstract)) {
            throw new \InvalidArgumentException(sprintf('Abstract must be a boolean, "%s" given', gettype($abstract)));
        }
        $this->abstract = $abstract;
        return $this;
    }
    /**
     * @return bool
     */
    public function getAbstract()
    {
        return $this->abstract;
    }
    /**
     * @return string
     */
    protected function getPhpAbstract()
    {
        return $this->getAbstract() === false ? '' : static::PHP_ABSTRACT_KEYWORD . ' ';
    }
    /**
     * @throws \InvalidArgumentException
     * @param string|PhpClass|null $extends
     * @return PhpClass
     */
    public function setExtends($extends)
    {
        if (!self::extendsIsValid($extends)) {
            throw new \InvalidArgumentException('Extends must be a string or a PhpClass instance');
        }
        $this->extends = $extends;
        return $this;
    }
    /**
     * @param string|PhpClass|null $extends
     * @return bool
     */
    public static function extendsIsValid($extends)
    {
        return $extends === null || self::stringIsValid($extends, true, true) || $extends instanceof PhpClass;
    }
    /**
     * @return string|PhpClass
     */
    public function getExtends()
    {
        return $this->extends;
    }
    /**
     * @return string
     */
    protected function getPhpExtends()
    {
        $extends = $this->getExtends();
        return empty($extends) ? '' : sprintf(' %s %s', static::PHP_EXTENDS_KEYWORD, ($extends instanceof PhpClass ? $extends->getName() : $extends));
    }
    /**
     * @throws \InvalidArgumentException
     * @param string[]|PhpClass[] $interfaces
     * @return PhpClass
     */
    public function setInterfaces(array $interfaces = array())
    {
        if (!self::interfacesAreValid($interfaces)) {
            throw new \InvalidArgumentException('Interfaces are not valid');
        }
        $this->interfaces = $interfaces;
        return $this;
    }
    /**
     * @param string[]|PhpClass[] $interfaces
     * @return bool
     */
    public static function interfacesAreValid(array $interfaces = array())
    {
        $valid = true;
        foreach ($interfaces as $interface) {
            $valid &= self::interfaceIsValid($interface);
        }
        return (bool) $valid;
    }
    /**
     * @param string|PhpClass $interface
     * @return bool
     */
    public static function interfaceIsValid($interface)
    {
        return self::stringIsValid($interface) || $interface instanceof PhpClass;
    }
    /**
     *
     * @return string[]|PhpClass[]
     */
    public function getInterfaces()
    {
        return $this->interfaces;
    }
    /**
     * @return string
     */
    protected function getPhpInterfaces()
    {
        $interfaces = array();
        foreach ($this->getInterfaces() as $interface) {
            $interfaces[] = $this->getPhpInterface($interface);
        }
        return empty($interfaces) ? '' : sprintf(' %s%s', static::PHP_IMPLEMENTS_KEYWORD, implode(',', $interfaces));
    }
    /**
     * @param string|PhpClass $interface
     * @return string
     */
    protected function getPhpInterface($interface)
    {
        return sprintf(' %s', is_string($interface) ? $interface : $interface->getName());
    }
    /**
     * @return string
     */
    public function getPhpDeclaration()
    {
        return trim(sprintf('%s%s %s%s%s', $this->getPhpAbstract(), static::PHP_DECLARATION, $this->getPhpName(), $this->getPhpExtends(), $this->getPhpInterfaces()));
    }
    /**
     * defines authorized children element types
     * @return string[]
     */
    public function getChildrenTypes()
    {
        return array(
            'string',
            'WsdlToPhp\\PhpGenerator\\Element\\PhpAnnotationBlock',
            'WsdlToPhp\\PhpGenerator\\Element\\PhpMethod',
            'WsdlToPhp\\PhpGenerator\\Element\\PhpConstant',
            'WsdlToPhp\\PhpGenerator\\Element\\PhpProperty',
        );
    }
    /**
     * Allows to indicate that children are contained by brackets,
     * in the case the method returns true, getBracketBeforeChildren
     * is called instead of getLineBeforeChildren and getBracketAfterChildren
     * is called instead of getLineAfterChildren, but be aware that these methods
     * call the two others
     * @return bool
     */
    public function useBracketsForChildren()
    {
        return true;
    }
}
