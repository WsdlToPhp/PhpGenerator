<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

interface GenerateableInterface
{
    public const INDENTATION_CHAR = '    ';

    public const BREAK_LINE_CHAR = "\n";

    /**
     * opening a function/class.
     */
    public const OPEN_BRACKET = '{';

    /**
     * closing a function/class.
     */
    public const CLOSE_BRACKET = '}';

    /**
     * opening an annotation.
     */
    public const OPEN_ANNOTATION = '/**';

    /**
     * closing an annotation.
     */
    public const CLOSE_ANNOTATION = ' */';

    public function __toString(): string;

    /**
     * Must return the strict representation for the current element.
     */
    public function toString(?int $indentation = null): string;

    /**
     * stores current indentation.
     */
    public function setIndentation(int $indentation);

    /**
     * Returns current indentation.
     */
    public function getIndentation(): int;

    /**
     * returns current indentation string to be used.
     */
    public function getIndentationString(?int $indentation = null): string;
}
