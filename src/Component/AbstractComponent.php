<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Component;

use InvalidArgumentException;
use WsdlToPhp\PhpGenerator\Element\AbstractElement;
use WsdlToPhp\PhpGenerator\Element\PhpAnnotationBlock as PhpAnnotationBlockElement;
use WsdlToPhp\PhpGenerator\Element\PhpClass as PhpClassElement;
use WsdlToPhp\PhpGenerator\Element\PhpConstant as PhpConstantElement;
use WsdlToPhp\PhpGenerator\Element\PhpFile as PhpFileElement;

abstract class AbstractComponent implements GenerateableInterface
{
    /**
     * @var PhpClassElement|PhpFileElement
     */
    protected $mainElement;

    public function __toString(): string
    {
        return $this->toString();
    }

    public function toString(): string
    {
        $content = [];
        foreach ($this->getElements() as $element) {
            $content[] = $this->getElementString($element);
        }

        return implode('', $content);
    }

    /**
     * @return AbstractElement[]|string[]
     */
    abstract public function getElements(): array;

    public function setMainElement(AbstractElement $element): self
    {
        if ($element instanceof PhpFileElement || $element instanceof PhpClassElement) {
            $this->mainElement = $element;
        } else {
            throw new InvalidArgumentException(sprintf('Element of type "%s" must be of type Element\PhpClass or Element\PhpFile', get_class($element)));
        }

        return $this;
    }

    /**
     * @return PhpClassElement|PhpFileElement
     */
    public function getMainElement(): AbstractElement
    {
        return $this->mainElement;
    }

    public function addConstantElement(PhpConstantElement $constant): self
    {
        if (!$constant->getClass() instanceof PhpClassElement && $this->mainElement instanceof PhpClassElement) {
            $constant->setClass($this->mainElement);
        }
        $this->mainElement->addChild($constant);

        return $this;
    }

    /**
     * @param mixed $value
     *
     * @return AbstractComponent
     */
    public function addConstant(string $name, $value = null, ?PhpClassElement $class = null): self
    {
        return $this->addConstantElement(new PhpConstantElement($name, $value, $class));
    }

    public function addAnnotationBlockElement(PhpAnnotationBlockElement $annotationBlock): self
    {
        $this->mainElement->addChild($annotationBlock);

        return $this;
    }

    /**
     * @param array|PhpAnnotationBlockElement|string $annotations
     *
     * @return AbstractComponent
     */
    public function addAnnotationBlock($annotations): self
    {
        return $this->addAnnotationBlockElement(new PhpAnnotationBlockElement(is_array($annotations) ? $annotations : [
            $annotations,
        ]));
    }

    /**
     * @param AbstractElement|string $element
     *
     * @throws InvalidArgumentException
     */
    protected function getElementString($element): string
    {
        $string = '';
        if (is_scalar($element)) {
            $string = $element;
        } elseif ($element instanceof AbstractElement) {
            $string = $element->toString();
        }

        return $string;
    }
}
