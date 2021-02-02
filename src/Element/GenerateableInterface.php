<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

interface GenerateableInterface
{
    const INDENTATION_CHAR = '    ';

    const BREAK_LINE_CHAR = "\n";

    /**
     * opening a function/class.
     */
    const OPEN_BRACKET = '{';

    /**
     * closing a function/class.
     */
    const CLOSE_BRACKET = '}';

    /**
     * opening an annotation.
     */
    const OPEN_ANNOTATION = '/**';

    /**
     * closing an annotation.
     */
    const CLOSE_ANNOTATION = ' */';

    public function __toString(): string;

    /**
     * Must return the strict representation for the current element.
     */
    public function toString(?int $indentation = null): string;

    /**
     * stores current indentation.
     *
     * @param int
     */
    public function setIndentation(int $indentation);

    /**
     * returns current identation.
     */
    public function getIndentation(): int;

    /**
     * returns current indentation string to be used.
     *
     * @param int $indentation
     */
    public function getIndentationString(?int $indentation = null): string;
}
