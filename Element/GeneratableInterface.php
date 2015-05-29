<?php

namespace WsdlToPhp\PhpGenerator\Element;

interface GeneratableInterface
{
    /**
     * Must return the strict representation for the current element
     */
    public function toString();
}
