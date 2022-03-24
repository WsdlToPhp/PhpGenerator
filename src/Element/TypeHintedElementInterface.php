<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

interface TypeHintedElementInterface
{
    public const TYPE_ARRAY = 'array';
    public const TYPE_CALLABLE = 'callable';
    public const TYPE_BOOL = 'bool';
    public const TYPE_INT = 'int';
    public const TYPE_ITERABLE = 'iterable';
    public const TYPE_FLOAT = 'float';
    public const TYPE_OBJECT = 'object';
    public const TYPE_STRING = 'string';

    public const TYPES = [
        self::TYPE_ARRAY,
        self::TYPE_CALLABLE,
        self::TYPE_BOOL,
        self::TYPE_INT,
        self::TYPE_ITERABLE,
        self::TYPE_FLOAT,
        self::TYPE_OBJECT,
        self::TYPE_STRING,
    ];

    public function setType($type): AbstractElement;

    public function getType();

    public static function typeIsValid(?string $access): bool;
}
