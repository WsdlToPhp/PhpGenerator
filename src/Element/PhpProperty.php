<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

class PhpProperty extends PhpVariable implements AccessRestrictedElementInterface, TypeHintedElementInterface
{
    use AccessRestrictedElementTrait;
    use TypeHintedElementTrait;

    public function __construct(string $name, $value = null, string $access = self::ACCESS_PUBLIC, $type = null)
    {
        parent::__construct($name, $value);
        $this->setType($type);
        $this->setAccess($access);
    }

    public function getPhpDeclaration(): string
    {
        return implode('', [
            $this->getPhpAccess(),
            $this->getPhpType(),
            $this->getAssignmentDeclarator(),
            $this->getPhpName(),
            $this->getAssignmentSign(),
            $this->getPhpValue(),
            $this->getAssignmentFinishing(),
            $this->endsWithSemicolon() ? ';' : '',
        ]);
    }
}
