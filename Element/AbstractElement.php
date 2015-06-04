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
            throw new \InvalidArgumentException(sprintf('Name "%s" is invalid, please provide a valid name', $name));
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
     * @return bool
     */
    public static function nameIsValid($name)
    {
        return preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/D', $name) === 1;
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\GenerableInterface::toString()
     * @param int $indentation
     * @return string
     */
    public function toString($indentation = null)
    {
        $lines = array();
        $declaration = $this->getPhpDeclaration();
        if (!empty($declaration)) {
            $lines = array(
                $this->getIndentedString($declaration, $indentation),
            );
        }
        $before = $this->getContextualLineBeforeChildren($indentation);
        if (!empty($before)) {
            $lines[] = $before;
        }
        foreach ($this->getChildren() as $child) {
            $lines[] = $this->getChildContent($child, $indentation + ($this->useBracketsForChildren() ? 1 : 0));
        }
        $after = $this->getContextualLineAfterChildren($indentation);
        if (!empty($after)) {
            $lines[] = $after;
        }
        return implode(self::BREAK_LINE_CHAR, $lines);
    }
    /**
     * @param string|AbstractElement $child
     * @param int $indentation
     * @throws \InvalidArgumentException
     * @return string
     */
    protected function getChildContent($child, $indentation = null)
    {
        if (is_string($child)) {
            $content = $this->getIndentedString($child, $indentation);
        } elseif ($child instanceof AbstractElement) {
            $content = $child->toString($indentation === null ? $this->getIndentation() : $indentation);
        } else {
            throw new \InvalidArgumentException(sprintf('Child\'s content could not be generated for: %s:%s', gettype($child), is_object($child) ? get_class($child) : 'not an object'));
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
     * @param mixed $child
     * @throws \InvalidArgumentException
     * @return AbstractElement
     */
    public function addChild($child)
    {
        if (!$this->childrenIsValid($child)) {
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
    protected function childrenIsValid($child)
    {
        $valid = false;
        $authorizedTypes = $this->getChildrenTypes();
        if (!empty($authorizedTypes)) {
            foreach ($authorizedTypes as $authorizedType) {
                $valid |= (gettype($child) === $authorizedType) || (is_object($child) && get_class($child) === $authorizedType);
            }
        }
        return (bool)$valid;
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
     * @return string
     */
    public function getIndentedString($string, $indentation = null)
    {
        return sprintf('%s%s', $this->getIndentationString($indentation), $string);
    }
}
