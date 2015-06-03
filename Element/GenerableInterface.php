<?php

namespace WsdlToPhp\PhpGenerator\Element;

interface GenerableInterface
{
    /**
     * @var string
     */
    const INDENTATION_CHAR = '    ';
    /**
     * @var string
     */
    const BREAK_LINE_CHAR = "\n";
    /**
     * opening a function/class
     * @var string
     */
    const OPEN_BRACKET = '{';
    /**
     * closing a function/class
     * @var string
     */
    const CLOSE_BRACKET = '}';
    /**
     * opening an annotation
     * @var string
     */
    const OPEN_ANNOTATION = '/**';
    /**
     * closing an annotation
     * @var string
     */
    const CLOSE_ANNOTATION = ' */';
    /**
     * Must return the strict representation for the current element
     * @param int $indentation
     * @return string
     */
    public function toString($indentation = 0);
    /**
     * stores current indentation
     * @param int
     */
    public function setIndentation($indentation);
    /**
     * returns current identation
     * @return int
     */
    public function getIndentation();
    /**
     * returns current indentation string to be used
     * @param int $indentation
     * @return string
     */
    public function getIndentationString($indentation = null);
}
