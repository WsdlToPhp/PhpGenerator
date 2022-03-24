<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Component;

interface GenerateableInterface
{
    public const BREAK_LINE_CHAR = "\n";

    public function __toString(): string;

    /**
     * Must return the strict representation for the current element.
     */
    public function toString(): string;
}
