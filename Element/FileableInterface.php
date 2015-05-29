<?php

namespace WsdlToPhp\PhpGenerator\Element;

interface FileableInterface
{
    /**
     * Must return true if the element can be generated alone in a file
     * @return bool
     */
    public function canBeAlone();
}
