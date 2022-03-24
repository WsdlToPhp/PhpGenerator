<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

interface AssignedValueElementInterface
{
    /**
     * Use this constant as value to ensure element has not assigned value.
     */
    public const NO_VALUE = '##NO_VALUE##';

    public function setValue($value): AbstractElement;

    public function getValue();

    public function hasValue(): bool;

    public function getPhpValue(): ?string;

    /**
     * returns the way the assignment is declared.
     */
    public function getAssignmentDeclarator(): string;

    /**
     * returns the way the value is assigned to the element.
     */
    public function getAssignmentSign(): string;

    /**
     * returns the way the assignment is finished.
     */
    public function getAssignmentFinishing(): string;

    /**
     * indicates if the element accepts non scalar value.
     */
    public function getAcceptNonScalarValue(): bool;

    /**
     * indicates if the element finishes with a semicolon or not.
     */
    public function endsWithSemicolon(): bool;
}
