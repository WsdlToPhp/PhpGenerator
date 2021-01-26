<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

use InvalidArgumentException;

class PhpClass extends AbstractElement
{
    const PHP_DECLARATION = 'class';

    const PHP_ABSTRACT_KEYWORD = 'abstract';

    const PHP_IMPLEMENTS_KEYWORD = 'implements';

    const PHP_EXTENDS_KEYWORD = 'extends';

    protected bool $abstract;

    /**
     * @var string|PhpClass
     */
    protected $extends;

    /**
     * @var string[]|PhpClass[]
     */
    protected array $interfaces;

    public function __construct(string $name, bool $abstract = false, $extends = null, array $interfaces = [])
    {
        parent::__construct($name);
        $this
            ->setAbstract($abstract)
            ->setExtends($extends)
            ->setInterfaces($interfaces);
    }

    public function setAbstract(bool $abstract): self
    {
        $this->abstract = $abstract;

        return $this;
    }

    public function getAbstract(): bool
    {
        return $this->abstract;
    }

    protected function getPhpAbstract(): string
    {
        return $this->getAbstract() === false ? '' : static::PHP_ABSTRACT_KEYWORD . ' ';
    }

    /**
     * @throws InvalidArgumentException
     * @param string|PhpClass|null $extends
     * @return PhpClass
     */
    public function setExtends($extends): self
    {
        if (!self::extendsIsValid($extends)) {
            throw new InvalidArgumentException('Extends must be a string or a PhpClass instance');
        }
        $this->extends = $extends;

        return $this;
    }

    /**
     * @param string|PhpClass|null $extends
     * @return bool
     */
    public static function extendsIsValid($extends): bool
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

    protected function getPhpExtends(): string
    {
        $extends = $this->getExtends();

        return empty($extends) ? '' : sprintf(' %s %s', static::PHP_EXTENDS_KEYWORD, ($extends instanceof PhpClass ? $extends->getName() : $extends));
    }

    /**
     * @throws InvalidArgumentException
     * @param string[]|PhpClass[] $interfaces
     * @return PhpClass
     */
    public function setInterfaces(array $interfaces = []): self
    {
        if (!self::interfacesAreValid($interfaces)) {
            throw new InvalidArgumentException('Interfaces are not valid');
        }
        $this->interfaces = $interfaces;

        return $this;
    }

    /**
     * @param string[]|PhpClass[] $interfaces
     * @return bool
     */
    public static function interfacesAreValid(array $interfaces = []): bool
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
    public static function interfaceIsValid($interface): bool
    {
        return self::stringIsValid($interface) || $interface instanceof PhpClass;
    }

    /**
     *
     * @return string[]|PhpClass[]
     */
    public function getInterfaces(): array
    {
        return $this->interfaces;
    }

    /**
     * @return string
     */
    protected function getPhpInterfaces(): string
    {
        $interfaces = [];
        foreach ($this->getInterfaces() as $interface) {
            $interfaces[] = $this->getPhpInterface($interface);
        }

        return empty($interfaces) ? '' : sprintf(' %s%s', static::PHP_IMPLEMENTS_KEYWORD, implode(',', $interfaces));
    }

    /**
     * @param string|PhpClass $interface
     * @return string
     */
    protected function getPhpInterface($interface): string
    {
        return sprintf(' %s', is_string($interface) ? $interface : $interface->getName());
    }

    public function getPhpDeclaration(): string
    {
        return trim(sprintf('%s%s %s%s%s', $this->getPhpAbstract(), static::PHP_DECLARATION, $this->getPhpName(), $this->getPhpExtends(), $this->getPhpInterfaces()));
    }

    /**
     * defines authorized children element types
     * @return string[]
     */
    public function getChildrenTypes(): array
    {
        return [
            'string',
            PhpAnnotationBlock::class,
            PhpMethod::class,
            PhpConstant::class,
            PhpProperty::class,
        ];
    }

    /**
     * Allows to indicate that children are contained by brackets,
     * in the case the method returns true, getBracketBeforeChildren
     * is called instead of getLineBeforeChildren and getBracketAfterChildren
     * is called instead of getLineAfterChildren, but be aware that these methods
     * call the two others
     * @return bool
     */
    public function useBracketsForChildren(): bool
    {
        return true;
    }
}
