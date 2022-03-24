<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

use InvalidArgumentException;

class PhpClass extends AbstractElement
{
    public const PHP_DECLARATION = 'class';

    public const PHP_ABSTRACT_KEYWORD = 'abstract';

    public const PHP_IMPLEMENTS_KEYWORD = 'implements';

    public const PHP_EXTENDS_KEYWORD = 'extends';

    protected bool $abstract;

    /**
     * @var PhpClass|string
     */
    protected $extends;

    /**
     * @var PhpClass[]|string[]
     */
    protected array $interfaces;

    public function __construct(string $name, bool $abstract = false, $extends = null, array $interfaces = [])
    {
        parent::__construct($name);
        $this
            ->setAbstract($abstract)
            ->setExtends($extends)
            ->setInterfaces($interfaces)
        ;
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

    /**
     * @param null|PhpClass|string $extends
     *
     * @throws InvalidArgumentException
     */
    public function setExtends($extends): self
    {
        if (!static::extendsIsValid($extends)) {
            throw new InvalidArgumentException('Extends must be a string or a PhpClass instance');
        }
        $this->extends = $extends;

        return $this;
    }

    /**
     * @param null|PhpClass|string $extends
     */
    public static function extendsIsValid($extends): bool
    {
        return is_null($extends) || static::stringIsValid($extends, true, true) || $extends instanceof PhpClass;
    }

    /**
     * @return null|PhpClass|string
     */
    public function getExtends()
    {
        return $this->extends;
    }

    /**
     * @param PhpClass[]|string[] $interfaces
     *
     * @throws InvalidArgumentException
     */
    public function setInterfaces(array $interfaces = []): self
    {
        if (!static::interfacesAreValid($interfaces)) {
            throw new InvalidArgumentException('Interfaces are not valid');
        }
        $this->interfaces = $interfaces;

        return $this;
    }

    /**
     * @param PhpClass[]|string[] $interfaces
     */
    public static function interfacesAreValid(array $interfaces = []): bool
    {
        $valid = true;
        foreach ($interfaces as $interface) {
            $valid &= static::interfaceIsValid($interface);
        }

        return (bool) $valid;
    }

    /**
     * @param PhpClass|string $interface
     */
    public static function interfaceIsValid($interface): bool
    {
        return static::stringIsValid($interface) || $interface instanceof PhpClass;
    }

    /**
     * @return PhpClass[]|string[]
     */
    public function getInterfaces(): array
    {
        return $this->interfaces;
    }

    public function getPhpDeclaration(): string
    {
        return trim(sprintf('%s%s %s%s%s', $this->getPhpAbstract(), static::PHP_DECLARATION, $this->getPhpName(), $this->getPhpExtends(), $this->getPhpInterfaces()));
    }

    /**
     * defines authorized children element types.
     *
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
     * call the two others.
     */
    public function useBracketsForChildren(): bool
    {
        return true;
    }

    protected function getPhpAbstract(): string
    {
        return !$this->getAbstract() ? '' : static::PHP_ABSTRACT_KEYWORD.' ';
    }

    protected function getPhpExtends(): string
    {
        $extends = $this->getExtends();

        return empty($extends) ? '' : sprintf(' %s %s', static::PHP_EXTENDS_KEYWORD, ($extends instanceof PhpClass ? $extends->getName() : $extends));
    }

    protected function getPhpInterfaces(): string
    {
        $interfaces = [];
        foreach ($this->getInterfaces() as $interface) {
            $interfaces[] = $this->getPhpInterface($interface);
        }

        return empty($interfaces) ? '' : sprintf(' %s%s', static::PHP_IMPLEMENTS_KEYWORD, implode(',', $interfaces));
    }

    /**
     * @param PhpClass|string $interface
     */
    protected function getPhpInterface($interface): string
    {
        return sprintf(' %s', is_string($interface) ? $interface : $interface->getName());
    }
}
