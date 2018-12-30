<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

class PhpFile extends AbstractElement
{
    /**
     * @var string
     */
    const START_FILE = '<?php';
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\AbstractElement::getPhpDeclaration()
     * @return string
     */
    public function getPhpDeclaration(): string
    {
        return self::START_FILE;
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\AbstractElement::toString()
     * @param int $indentation
     * @return string
     */
    public function toString(int $indentation = null): string
    {
        return sprintf('%s%s', parent::toString($indentation), self::BREAK_LINE_CHAR);
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\AbstractElement::getChildrenTypes()
     * @return string[]
     */
    public function getChildrenTypes(): array
    {
        return [
            'string',
            PhpAnnotationBlock::class,
            PhpClass::class,
            PhpConstant::class,
            PhpFunction::class,
            PhpInterface::class,
            PhpVariable::class,
        ];
    }
}
