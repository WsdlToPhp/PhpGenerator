<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

interface AccessRestrictedElementInterface
{
    const ACCESS_PRIVATE = 'private';

    const ACCESS_PROTECTED = 'protected';

    const ACCESS_PUBLIC = 'public';

    public function setAccess(?string $access): AbstractElement;

    public function getAccess(): string;

    public static function getAccesses(): array;

    public static function accessIsValid(?string $access): bool;
}
