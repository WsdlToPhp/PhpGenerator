<?php

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
    public function getPhpDeclaration()
    {
        return self::START_FILE;
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\AbstractElement::toString()
     * @param int $indentation
     * @return string
     */
    public function toString($indentation = null)
    {
        return sprintf('%s%s', parent::toString($indentation), self::BREAK_LINE_CHAR);
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\AbstractElement::getChildrenTypes()
     * @return string[]
     */
    public function getChildrenTypes()
    {
        return array(
            'string',
            'WsdlToPhp\\PhpGenerator\\Element\\PhpAnnotationBlock',
            'WsdlToPhp\\PhpGenerator\\Element\\PhpClass',
            'WsdlToPhp\\PhpGenerator\\Element\\PhpConstant',
            'WsdlToPhp\\PhpGenerator\\Element\\PhpFunction',
            'WsdlToPhp\\PhpGenerator\\Element\\PhpInterface',
            'WsdlToPhp\\PhpGenerator\\Element\\PhpVariable',
        );
    }
}
