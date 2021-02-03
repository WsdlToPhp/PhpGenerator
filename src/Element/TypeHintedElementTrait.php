<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

use InvalidArgumentException;

trait TypeHintedElementTrait
{
    /**
     * @var PhpClass|string
     */
    protected $type;

    /**
     * @param PhpClass|string $type
     *
     * @throws InvalidArgumentException
     *
     * @return PhpFunctionParameter
     */
    public function setType($type): AbstractElement
    {
        if (!static::typeIsValid($type)) {
            throw new InvalidArgumentException(sprintf('Type "%s" is not valid', gettype($type)));
        }
        $this->type = $type;

        return $this;
    }

    /**
     * @param PhpClass|string $type
     */
    public static function typeIsValid($type): bool
    {
        return
            null === $type
            || $type instanceof PhpClass
            || (is_string($type) && class_exists($type))
            || in_array($type, TypeHintedElementInterface::TYPES, true)
            || self::stringIsValid($type, true, true);
    }

    /**
     * @return PhpClass|string
     */
    public function getType()
    {
        return $this->type;
    }

    protected function getPhpType(): string
    {
        $type = $this->getType();

        return empty($type) ? '' : sprintf('%s ', $type instanceof PhpClass ? $type->getPhpName() : $type);
    }
}
