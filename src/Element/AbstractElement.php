<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

abstract class AbstractElement implements GenerateableInterface
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var AbstractElement[]|mixed[]
     */
    protected $children;
    /**
     * @var int
     */
    protected $indentation;
    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->setName($name);
        $this->children = [];
        $this->indentation = 0;
    }
    /**
     * @throws \InvalidArgumentException
     * @param string $name
     * @return AbstractElement
     */
    public function setName(string $name)
    {
        if (!self::nameIsValid($name)) {
            throw new \InvalidArgumentException(sprintf('Name "%s" is invalid when instantiating %s object', $name, $this->getCalledClass()));
        }
        $this->name = $name;
        return $this;
    }
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param string $name
     * @param bool $allowBackslash
     * @return bool
     */
    public static function nameIsValid(string $name, bool $allowBackslash = false)
    {
        $pattern = '/[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/';
        if ($allowBackslash === true) {
            $pattern = '/[a-zA-Z_\x7f-\xff\\\][a-zA-Z0-9_\x7f-\xff\\\]*/';
        }
        return preg_match($pattern, (string) $name);
    }
    /**
     * @param mixed $string
     * @param bool $checkName
     * @param bool $allowBackslash
     * @return bool
     */
    public static function stringIsValid($string, bool $checkName = true, bool $allowBackslash = false): bool
    {
        return (is_string($string) && !empty($string) && (!$checkName || self::nameIsValid($string, $allowBackslash)));
    }
    /**
     * @param mixed $object
     * @param mixed $checkClass
     * @return bool
     */
    public static function objectIsValid($object, ?string $checkClass = null): bool
    {
        return (is_object($object) && ($checkClass === null || get_class($object) === $checkClass));
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\GenerateableInterface::toString()
     * @param int $indentation
     * @return string
     */
    public function toString(int $indentation = null): string
    {
        $lines = [
            $this->getToStringDeclaration($indentation),
            $this->getToStringBeforeChildren($indentation),
        ];
        foreach ($this->getChildren() as $child) {
            $lines[] = $this->getChildContent($child, $indentation + ($this->useBracketsForChildren() ? 1 : 0));
        }
        $lines[] = $this->getToStringAfterChildren($indentation);
        return implode(self::BREAK_LINE_CHAR, self::cleanArrayToString($lines));
    }
    /**
     * @param int $indentation
     * @return string|null
     */
    private function getToStringDeclaration(int $indentation = null): ?string
    {
        $declaration = $this->getPhpDeclaration();
        if (!empty($declaration)) {
            return $this->getIndentedString($declaration, $indentation);
        }
        return null;
    }
    /**
     * @param int $indentation
     * @return string|null
     */
    private function getToStringBeforeChildren(int $indentation = null): ?string
    {
        $before = $this->getContextualLineBeforeChildren($indentation);
        if (!empty($before)) {
            return $before;
        }
        return null;
    }
    /**
     * @param int $indentation
     * @return string|null
     */
    private function getToStringAfterChildren(int $indentation = null): ?string
    {
        $after = $this->getContextualLineAfterChildren($indentation);
        if (!empty($after)) {
            return $after;
        }
        return null;
    }
    /**
     * @param array $array
     * @return array
     */
    private static function cleanArrayToString(array $array): array
    {
        $newArray = [];
        foreach ($array as $line) {
            if ($line !== null) {
                $newArray[] = $line;
            }
        }
        return $newArray;
    }
    /**
     * @throws \InvalidArgumentException
     * @param string|AbstractElement $child
     * @param int $indentation
     * @return string
     */
    protected function getChildContent($child, int $indentation = null): string
    {
        $content = '';
        if (is_string($child)) {
            $content = $this->getIndentedString($child, $indentation);
        } elseif ($child instanceof AbstractElement) {
            $content = $child->toString($indentation === null ? $this->getIndentation() : $indentation);
        }
        return $content;
    }
    /**
     * @return string
     */
    public function getPhpName(): string
    {
        return sprintf('%s', $this->getName());
    }
    /**
     * @throws \InvalidArgumentException
     * @param mixed $child
     * @return AbstractElement
     */
    public function addChild($child): AbstractElement
    {
        if (!$this->childIsValid($child)) {
            $types = $this->getChildrenTypes();
            if (empty($types)) {
                throw new \InvalidArgumentException('This element does not accept any child element');
            } else {
                throw new \InvalidArgumentException(sprintf('Element of type "%s:%s" is not authorized, please provide one of these types: %s', gettype($child), is_object($child) ? get_class($child) : 'unknown', implode(', ', $this->getChildrenTypes())));
            }
        }
        $this->children[] = $child;
        return $this;
    }
    /**
     * @param mixed $child
     * @return bool
     */
    protected function childIsValid($child): bool
    {
        $valid = false;
        $authorizedTypes = $this->getChildrenTypes();
        if (!empty($authorizedTypes)) {
            foreach ($authorizedTypes as $authorizedType) {
                $valid |= (gettype($child) === $authorizedType) || self::objectIsValid($child, $authorizedType);
            }
        }
        return (bool) $valid;
    }
    /**
     * @return AbstractElement[]|mixed[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }
    /**
     * @return string
     */
    abstract public function getPhpDeclaration(): string;
    /**
     * defines authorized children element types
     * @return string[]
     */
    abstract public function getChildrenTypes(): array;
    /**
     * @param int $indentation
     * @return string
     */
    private function getContextualLineBeforeChildren(int $indentation = null): string
    {
        if ($this->useBracketsForChildren()) {
            $line = $this->getBracketBeforeChildren($indentation);
        } else {
            $line = $this->getLineBeforeChildren($indentation);
        }
        return $line;
    }
    /**
     * @param int $indentation
     * @return string
     */
    private function getContextualLineAfterChildren(int $indentation = null): string
    {
        if ($this->useBracketsForChildren()) {
            $line = $this->getBracketAfterChildren($indentation);
        } else {
            $line = $this->getLineAfterChildren($indentation);
        }
        return $line;
    }
    /**
     * Allows to generate content before children content is generated
     * @param int $indentation
     * @return string
     */
    public function getLineBeforeChildren(int $indentation = null): string
    {
        return '';
    }
    /**
     * Allows to generate content after children content is generated
     * @param int $indentation
     * @return string
     */
    public function getLineAfterChildren(int $indentation = null): string
    {
        return '';
    }
    /**
     * Allows to indicate that children are contained by brackets,
     * in the case the method returns true, getBracketBeforeChildren
     * is called instead of getLineBeforeChildren and getBracketAfterChildren
     * is called instead of getLineAfterChildren, but be aware that these methods
     * call the two others
     * @return bool
     */
    public function useBracketsForChildren(): bool
    {
        return false;
    }
    /**
     * Allows to generate content before children content is generated
     * @param int $indentation
     * @return string
     */
    public function getBracketBeforeChildren(int $indentation = null): string
    {
        $line = $this->getIndentedString(self::OPEN_BRACKET, $indentation);
        $this->setIndentation(($indentation === null ? $this->getIndentation() : $indentation) + 1);
        return $line;
    }
    /**
     * Allows to generate content after children content is generated
     * @param int $indentation
     * @return string
     */
    public function getBracketAfterChildren(int $indentation = null): string
    {
        $this->setIndentation(($indentation === null ? $this->getIndentation() : $indentation) - 1);
        return $this->getIndentedString(self::CLOSE_BRACKET, $indentation);
    }
    /**
     * @param int $indentation
     * @return AbstractElement
     */
    public function setIndentation(int $indentation): AbstractElement
    {
        $this->indentation = $indentation;
        return $this;
    }
    /**
     * @return int
     */
    public function getIndentation(): int
    {
        return $this->indentation;
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\GenerateableInterface::getIndentationString()
     * @param int $indentation
     * @return string
     */
    public function getIndentationString(int $indentation = null): string
    {
        return str_repeat(self::INDENTATION_CHAR, $indentation === null ? $this->getIndentation() : $indentation);
    }
    /**
     * @param string $string
     * @param int $indentation
     * @return string
     */
    public function getIndentedString(string $string, int $indentation = null): string
    {
        $strings = explode(self::BREAK_LINE_CHAR, $string);
        foreach ($strings as $i => $s) {
            $strings[$i] = sprintf('%s%s', $this->getIndentationString($indentation), $s);
        }
        return implode(self::BREAK_LINE_CHAR, $strings);
    }
    /**
     * @return string
     */
    final public function getCalledClass(): string
    {
        return substr(get_called_class(), strrpos(get_called_class(), '\\') + 1);
    }
}
