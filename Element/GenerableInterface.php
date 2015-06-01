<?php

namespace WsdlToPhp\PhpGenerator\Element;

interface GenerableInterface
{
    const INDENTATION_CHAR = '    ';
    const BREAK_LINE_CHAR = "\n";
    /**
     * Must return the strict representation for the current element
     * @return string
     */
    public function toString();
}
