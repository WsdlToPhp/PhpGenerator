<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpAnnotation extends AbstractElement
{
    /**
     * @var string
     */
    const NO_NAME = "__NO_NAME__";
    /**
     * @var int
     */
    const MAX_LENGTH = 80;
    /**
     * @var string
     */
    protected $content;
    /**
     * @var int
     */
    protected $maxLength;
    /**
     * @param string $name
     * @param string $content
     * @param int $maxLength
     */
    public function __construct($name, $content, $maxLength = self::MAX_LENGTH)
    {
        parent::__construct($name);
        $this
            ->setContent($content)
            ->setMaxLength($maxLength);
    }
    /**
     * @param string $content
     * @return PhpAnnotation
     */
    public function setContent($content)
    {
        $this->content = trim($content);
        return $this;
    }
    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
    /**
     * @return bool
     */
    public function hasContent()
    {
        return !empty($this->content);
    }
    /**
     * @return string[]
     */
    protected function getPhpContent()
    {
        $fullContent = trim(sprintf('%s %s', $this->getPhpName(), $this->getContent()));
        $content = array(
            $fullContent,
        );
        if ($this->getPhpName() === '' && strlen($fullContent) > $this->getMaxLength()) {
            $content = explode(self::BREAK_LINE_CHAR, wordwrap($fullContent, $this->getMaxLength(), self::BREAK_LINE_CHAR, true));
        }
        return array_map(function ($element) {
            return sprintf(' %s', $element);
        }, $content);
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\AbstractElement::getPhpName()
     * @return string
     */
    public function getPhpName()
    {
        return (!empty($this->name) && $this->getName() !== static::NO_NAME) ? sprintf(' @%s', parent::getPhpName()) : '';
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\AbstractElement::getPhpDeclaration()
     * @return string
     */
    public function getPhpDeclaration()
    {
        return sprintf(' *%s', implode(sprintf('%s *', parent::BREAK_LINE_CHAR), $this->getPhpContent()));
    }
    /**
     * defines authorized children element types
     * @return string[]
     */
    public function getChildrenTypes()
    {
        return array();
    }
    /**
     * @param int $maxlength
     * @return PhpAnnotation
     */
    public function setMaxLength($maxlength)
    {
        $this->maxLength = $maxlength;
        return $this;
    }
    /**
     * @return int
     */
    public function getMaxLength()
    {
        return $this->maxLength;
    }
}
