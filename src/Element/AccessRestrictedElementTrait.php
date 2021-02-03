<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

use InvalidArgumentException;

trait AccessRestrictedElementTrait
{
    protected string $access;

    public function setAccess(?string $access): AbstractElement
    {
        if (!static::accessIsValid($access)) {
            throw new InvalidArgumentException(sprintf('Access "%s" is invalid, please provide one of these accesses: %s', $access, implode(', ', self::getAccesses())));
        }
        $this->access = $access;

        return $this;
    }

    public function getAccess(): string
    {
        return $this->access;
    }

    public static function getAccesses(): array
    {
        return [
            AccessRestrictedElementInterface::ACCESS_PRIVATE,
            AccessRestrictedElementInterface::ACCESS_PROTECTED,
            AccessRestrictedElementInterface::ACCESS_PUBLIC,
        ];
    }

    public static function accessIsValid(?string $access): bool
    {
        return null === $access || in_array($access, self::getAccesses(), true);
    }

    protected function getPhpAccess(): string
    {
        return null === $this->getAccess() ? '' : sprintf('%s ', $this->getAccess());
    }
}
