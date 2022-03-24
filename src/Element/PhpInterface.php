<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

class PhpInterface extends PhpClass
{
    public const PHP_DECLARATION = 'interface';

    public const PHP_IMPLEMENTS_KEYWORD = 'extends';

    public function getAbstract(): bool
    {
        return false;
    }

    public function getExtends()
    {
        return null;
    }

    public function getChildrenTypes(): array
    {
        return [
            'string',
            PhpAnnotationBlock::class,
            PhpMethod::class,
            PhpConstant::class,
        ];
    }

    public function addChild($child): AbstractElement
    {
        if ($child instanceof PhpMethod) {
            $child->setHasBody(false);
        }

        return parent::addChild($child);
    }
}
