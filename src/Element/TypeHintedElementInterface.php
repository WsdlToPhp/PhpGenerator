<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

interface TypeHintedElementInterface
{
    const TYPE_ARRAY = 'array';
    const TYPE_CALLABLE = 'callable';
    const TYPE_BOOL = 'bool';
    const TYPE_INT = 'int';
    const TYPE_ITERABLE = 'iterable';
    const TYPE_FLOAT = 'float';
    const TYPE_OBJECT = 'object';
    const TYPE_STRING = 'string';

    const TYPES = [
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
