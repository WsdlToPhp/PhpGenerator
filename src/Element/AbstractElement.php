<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

use InvalidArgumentException;

abstract class AbstractElement implements GenerateableInterface
{
    protected string $name;

    /**
     * @var AbstractElement[]|mixed[]
     */
    protected array $children = [];

    protected int $indentation = 0;

    public function __construct(string $name)
    {
        $this->setName($name);
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function setName(string $name): self
    {
        if (!static::nameIsValid($name)) {
            throw new InvalidArgumentException(sprintf('Name "%s" is invalid when instantiating %s object', $name, $this->getCalledClass()));
        }
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function nameIsValid(string $name, bool $allowBackslash = false): bool
    {
        $pattern = '/[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/';
        if ($allowBackslash) {
            $pattern = '/[a-zA-Z_\x7f-\xff\\\][a-zA-Z0-9_\x7f-\xff\\\]*/';
        }

        return 1 === preg_match($pattern, (string) $name);
    }

    public static function stringIsValid($string, bool $checkName = true, bool $allowBackslash = false): bool
    {
        return is_string($string) && !empty($string) && (!$checkName || static::nameIsValid($string, $allowBackslash));
    }

    public static function objectIsValid($object, ?string $checkClass = null): bool
    {
        return is_object($object) && (is_null($checkClass) || get_class($object) === $checkClass);
    }

    public function toString(?int $indentation = null): string
    {
        $lines = [
            $this->getToStringDeclaration($indentation),
            $this->getToStringBeforeChildren($indentation),
        ];
        foreach ($this->getChildren() as $child) {
            if (empty($childContent = $this->getChildContent($child, $indentation + ($this->useBracketsForChildren() ? 1 : 0)))) {
                continue;
            }
            $lines[] = $childContent;
        }
        $lines[] = $this->getToStringAfterChildren($indentation);

        return implode(self::BREAK_LINE_CHAR, self::cleanArrayToString($lines));
    }

    public function getPhpName(): string
    {
        return sprintf('%s', $this->getName());
    }

    public function addChild($child): self
    {
        if (!$this->childIsValid($child)) {
            $types = $this->getChildrenTypes();
            if (empty($types)) {
                throw new InvalidArgumentException('This element does not accept any child element');
            }

            throw new InvalidArgumentException(sprintf('Element of type "%s:%s" is not authorized, please provide one of these types: %s', gettype($child), is_object($child) ? get_class($child) : 'unknown', implode(', ', $this->getChildrenTypes())));
        }
        $this->children[] = $child;

        return $this;
    }

    /**
     * @return AbstractElement[]|mixed[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    abstract public function getPhpDeclaration(): string;

    /**
     * defines authorized children element types.
     *
     * @return string[]
     */
    abstract public function getChildrenTypes(): array;

    /**
     * Allows to generate content before children content is generated.
     */
    public function getLineBeforeChildren(?int $indentation = null): string
    {
        return '';
    }

    /**
     * Allows to generate content after children content is generated.
     */
    public function getLineAfterChildren(?int $indentation = null): string
    {
        return '';
    }

    /**
     * Allows to indicate that children are contained by brackets,
     * in the case the method returns true, getBracketBeforeChildren
     * is called instead of getLineBeforeChildren and getBracketAfterChildren
     * is called instead of getLineAfterChildren, but be aware that these methods
     * call the two others.
     */
    public function useBracketsForChildren(): bool
    {
        return false;
    }

    /**
     * Allows to generate content before children content is generated.
     */
    public function getBracketBeforeChildren(?int $indentation = null): string
    {
        $line = $this->getIndentedString(self::OPEN_BRACKET, $indentation);
        $this->setIndentation((is_null($indentation) ? $this->getIndentation() : $indentation) + 1);

        return $line;
    }

    /**
     * Allows to generate content after children content is generated.
     */
    public function getBracketAfterChildren(?int $indentation = null): string
    {
        $this->setIndentation((is_null($indentation) ? $this->getIndentation() : $indentation) - 1);

        return $this->getIndentedString(self::CLOSE_BRACKET, $indentation);
    }

    public function setIndentation(int $indentation): self
    {
        $this->indentation = $indentation;

        return $this;
    }

    public function getIndentation(): int
    {
        return $this->indentation;
    }

    public function getIndentationString(?int $indentation = null): string
    {
        return str_repeat(self::INDENTATION_CHAR, is_null($indentation) ? $this->getIndentation() : $indentation);
    }

    public function getIndentedString(string $string, ?int $indentation = null): string
    {
        $strings = explode(self::BREAK_LINE_CHAR, $string);
        foreach ($strings as $i => $s) {
            $strings[$i] = sprintf('%s%s', $this->getIndentationString($indentation), $s);
        }

        return implode(self::BREAK_LINE_CHAR, $strings);
    }

    final public function getCalledClass(): string
    {
        return substr(get_called_class(), strrpos(get_called_class(), '\\') + 1);
    }

    protected function getChildContent($child, int $indentation = null): string
    {
        $content = '';
        if (is_string($child)) {
            $content = $this->getIndentedString($child, $indentation);
        } elseif ($child instanceof AbstractElement) {
            $content = $child->toString(is_null($indentation) ? $this->getIndentation() : $indentation);
        }

        return $content;
    }

    protected function childIsValid($child): bool
    {
        $valid = false;
        $authorizedTypes = $this->getChildrenTypes();
        if (!empty($authorizedTypes)) {
            foreach ($authorizedTypes as $authorizedType) {
                $valid |= (gettype($child) === $authorizedType) || static::objectIsValid($child, $authorizedType);
            }
        }

        return (bool) $valid;
    }

    private function getToStringDeclaration(int $indentation = null): ?string
    {
        $declaration = $this->getPhpDeclaration();
        if (!empty($declaration)) {
            return $this->getIndentedString($declaration, $indentation);
        }

        return null;
    }

    private function getToStringBeforeChildren(int $indentation = null): ?string
    {
        $before = $this->getContextualLineBeforeChildren($indentation);
        if (!empty($before)) {
            return $before;
        }

        return null;
    }

    private function getToStringAfterChildren(int $indentation = null): ?string
    {
        $after = $this->getContextualLineAfterChildren($indentation);
        if (!empty($after)) {
            return $after;
        }

        return null;
    }

    private static function cleanArrayToString(array $array): array
    {
        $newArray = [];
        foreach ($array as $line) {
            if (is_null($line)) {
                continue;
            }

            $newArray[] = $line;
        }

        return $newArray;
    }

    private function getContextualLineBeforeChildren(int $indentation = null): string
    {
        if ($this->useBracketsForChildren()) {
            $line = $this->getBracketBeforeChildren($indentation);
        } else {
            $line = $this->getLineBeforeChildren($indentation);
        }

        return $line;
    }

    private function getContextualLineAfterChildren(int $indentation = null): string
    {
        if ($this->useBracketsForChildren()) {
            $line = $this->getBracketAfterChildren($indentation);
        } else {
            $line = $this->getLineAfterChildren($indentation);
        }

        return $line;
    }
}
