<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Component;

interface GenerateableInterface
{
    const BREAK_LINE_CHAR = "\n";

    /**
     * Must return the strict representation for the current element
     * @return string
     */
    public function toString(): string;

    public function __toString(): string;
}
