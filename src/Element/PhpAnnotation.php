<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

class PhpAnnotation extends AbstractElement
{
    public const NO_NAME = '__NO_NAME__';

    public const MAX_LENGTH = 80;

    protected string $content;

    protected int $maxLength;

    public function __construct(string $name, string $content, int $maxLength = self::MAX_LENGTH)
    {
        parent::__construct($name);
        $this
            ->setContent($content)
            ->setMaxLength($maxLength)
        ;
    }

    public function setContent(string $content): self
    {
        $this->content = trim($content);

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function hasContent(): bool
    {
        return !empty($this->content);
    }

    public function getPhpName(): string
    {
        return (!empty($this->name) && $this->getName() !== static::NO_NAME) ? sprintf(' @%s', parent::getPhpName()) : '';
    }

    public function getPhpDeclaration(): string
    {
        return sprintf(' *%s', implode(sprintf('%s *', parent::BREAK_LINE_CHAR), $this->getPhpContent()));
    }

    public function getChildrenTypes(): array
    {
        return [];
    }

    public function setMaxLength(int $maxlength): self
    {
        $this->maxLength = $maxlength;

        return $this;
    }

    public function getMaxLength(): int
    {
        return $this->maxLength;
    }

    protected function getPhpContent(): array
    {
        $fullContent = trim(sprintf('%s %s', $this->getPhpName(), $this->getContent()));
        $content = [
            $fullContent,
        ];
        if ('' === $this->getPhpName() && strlen($fullContent) > $this->getMaxLength()) {
            $content = explode(self::BREAK_LINE_CHAR, wordwrap($fullContent, $this->getMaxLength(), self::BREAK_LINE_CHAR, true));
        }

        return array_map(function ($element) {
            return sprintf(' %s', $element);
        }, $content);
    }
}
