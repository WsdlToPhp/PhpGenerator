<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

class PhpFile extends AbstractElement
{
    public const START_FILE = '<?php';

    public function getPhpDeclaration(): string
    {
        return self::START_FILE;
    }

    public function getLineBeforeChildren(?int $indentation = null): string
    {
        return '';
    }

    public function toString(?int $indentation = null): string
    {
        return sprintf('%s%s', parent::toString($indentation), self::BREAK_LINE_CHAR);
    }

    public function getChildrenTypes(): array
    {
        return [
            'string',
            PhpAnnotationBlock::class,
            PhpClass::class,
            PhpConstant::class,
            PhpDeclare::class,
            PhpFunction::class,
            PhpInterface::class,
            PhpVariable::class,
        ];
    }
}
