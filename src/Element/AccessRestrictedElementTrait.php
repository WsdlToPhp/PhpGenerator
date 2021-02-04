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
            throw new InvalidArgumentException(sprintf('Access "%s" is invalid, please provide one of these accesses: %s', $access, implode(', ', AccessRestrictedElementInterface::ACCESSES)));
        }
        $this->access = $access;

        return $this;
    }

    public function getAccess(): string
    {
        return $this->access;
    }

    public static function accessIsValid(?string $access): bool
    {
        return '' === $access || in_array($access, AccessRestrictedElementInterface::ACCESSES, true);
    }

    protected function getPhpAccess(): string
    {
        return '' === $this->getAccess() ? '' : sprintf('%s ', $this->getAccess());
    }
}
