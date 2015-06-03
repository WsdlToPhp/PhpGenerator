<?php

namespace WsdlToPhp\PhpGenerator\Component;

interface GenerableInterface
{
    /**
     * @var string
     */
    const BREAK_LINE_CHAR = "\n";
    /**
     * Must return the strict representation for the current element
     * @return string
     */
    public function toString();
}
