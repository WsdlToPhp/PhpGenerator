<?php

namespace WsdlToPhp\PhpGenerator\Element;

interface SemicolonableInterface
{
    /**
     * Must return true if the element must end with a semicolon
     * @return bool
     */
    public function hasSemicolon();
}
