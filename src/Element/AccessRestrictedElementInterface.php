<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

interface AccessRestrictedElementInterface
{
    public const ACCESS_PRIVATE = 'private';

    public const ACCESS_PROTECTED = 'protected';

    public const ACCESS_PUBLIC = 'public';

    public const ACCESSES = [
        self::ACCESS_PRIVATE,
        self::ACCESS_PROTECTED,
        self::ACCESS_PUBLIC,
    ];

    public function setAccess(?string $access): AbstractElement;

    public function getAccess(): string;

    public static function accessIsValid(?string $access): bool;
}
