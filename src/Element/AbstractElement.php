<?php

namespace WsdlToPhp\PhpGenerator\Element;

abstract class AbstractElement implements GenerableInterface
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
    public function __construct($name)
    {
        $this->setName($name);
        $this->children = array();
        $this->indentation = 0;
    }
    /**
     * @param string $name
     * @return AbstractElement
     */
    public function setName($name)
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
    public static function nameIsValid($name, $allowBackslash = false)
    {
        $pattern = '/[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/';
        if ($allowBackslash === true) {
            $pattern = '/[a-zA-Z_\x7f-\xff\\\][a-zA-Z0-9_\x7f-\xff\\\]*/';
        }
        return preg_match($pattern, $name);
    }
    /**
     * @param mixed $string
     * @param bool $checkName
     * @param bool $allowBackslash
     * @return bool
     */
    public static function stringIsValid($string, $checkName = true, $allowBackslash = false)
    {
        return (is_string($string) && !empty($string) && (!$checkName || self::nameIsValid($string, $allowBackslash)));
    }
    /**
     * @param mixed $object
     * @return bool
     */
    public static function objectIsValid($object, $checkClass = null)
    {
        return (is_object($object) && ($checkClass === null || get_class($object) === $checkClass));
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\GenerableInterface::toString()
     * @param int $indentation
     * @return string
     */
    public function toString($indentation = null)
    {
        $lines = array(
            $this->getToStringDeclaration($indentation),
            $this->getToStringBeforeChildren($indentation),
        );
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
    private function getToStringDeclaration($indentation = null)
    {
        $declaration = $this->getPhpDeclaration();
        if (!empty($declaration)) {
            return $this->getIndentedString($declaration, $indentation);
        }
        return null;
    }
    /**
     * @param string $indentation
     * @return string|null
     */
    private function getToStringBeforeChildren($indentation = null)
    {
        $before = $this->getContextualLineBeforeChildren($indentation);
        if (!empty($before)) {
            return $before;
        }
        return null;
    }
    /**
     * @param string $indentation
     * @return string|null
     */
    private function getToStringAfterChildren($indentation = null)
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
    private static function cleanArrayToString($array)
    {
        $newArray = array();
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
    protected function getChildContent($child, $indentation = null)
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
    public function getPhpName()
    {
        return sprintf('%s', $this->getName());
    }
    /**
     * @throws \InvalidArgumentException
     * @param mixed $child
     * @return AbstractElement
     */
    public function addChild($child)
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
    protected function childIsValid($child)
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
    public function getChildren()
    {
        return $this->children;
    }
    /**
     * @return string
     */
    abstract public function getPhpDeclaration();
    /**
     * defines authorized children element types
     * @return string[]
     */
    abstract public function getChildrenTypes();
    /**
     * @param int $indentation
     * @return string
     */
    private function getContextualLineBeforeChildren($indentation = null)
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
    private function getContextualLineAfterChildren($indentation = null)
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
    public function getLineBeforeChildren($indentation = null)
    {
        return '';
    }
    /**
     * Allows to generate content after children content is generated
     * @param int $indentation
     * @return string
     */
    public function getLineAfterChildren($indentation = null)
    {
        return '';
    }
    /**
     * Allows to indicate that children are contained by brackets,
     * in the case the method returns true, getBracketBeforeChildren
     * is called instead of getLineBeforeChildren and getBracketAfterChildren
     * is called instead of getLineAfterChildren, but be aware that these methods
     * call the two others
     * @return boolean
     */
    public function useBracketsForChildren()
    {
        return false;
    }
    /**
     * Allows to generate content before children content is generated
     * @param int $indentation
     * @return string
     */
    public function getBracketBeforeChildren($indentation = null)
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
    public function getBracketAfterChildren($indentation = null)
    {
        $this->setIndentation(($indentation === null ? $this->getIndentation() : $indentation) - 1);
        return $this->getIndentedString(self::CLOSE_BRACKET, $indentation);
    }
    /**
     * @param int $indentation
     * @return AbstractElement
     */
    public function setIndentation($indentation)
    {
        $this->indentation = $indentation;
        return $this;
    }
    /**
     * @return int
     */
    public function getIndentation()
    {
        return $this->indentation;
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\GenerableInterface::getIndentationString()
     * @param int $indentation
     * @return string
     */
    public function getIndentationString($indentation = null)
    {
        return str_repeat(self::INDENTATION_CHAR, $indentation === null ? $this->getIndentation() : $indentation);
    }
    /**
     * @param string $string
     * @param int $indentation
     * @return string
     */
    public function getIndentedString($string, $indentation = null)
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
    final public function getCalledClass()
    {
        return substr(get_called_class(), strrpos(get_called_class(), '\\') + 1);
    }
}
