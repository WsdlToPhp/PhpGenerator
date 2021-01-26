<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

use InvalidArgumentException;

class PhpAnnotationBlock extends AbstractElement
{
    public function __construct(array $annotations = [])
    {
        parent::__construct('_');
        $this->setAnnotations($annotations);
    }

    /**
     * @throws InvalidArgumentException
     * @param string[]|array[]|PhpAnnotation[] $annotations
     * @return PhpAnnotationBlock
     */
    protected function setAnnotations(array $annotations): self
    {
        if (!static::annotationsAreValid($annotations)) {
            throw new InvalidArgumentException('Annotations are not valid');
        }
        $this->children = static::transformAnnotations($annotations);
        return $this;
    }

    /**
     * @param string[]|array[]|PhpAnnotation[] $annotations
     * @return PhpAnnotation[]
     */
    protected static function transformAnnotations(array $annotations): array
    {
        $finalAnnotations = [];
        foreach ($annotations as $annotation) {
            $finalAnnotations[] = self::transformAnnotation($annotation);
        }
        return $finalAnnotations;
    }

    /**
     * @throws InvalidArgumentException
     * @param string|array|PhpAnnotation $annotation
     * @return PhpAnnotation
     */
    protected static function transformAnnotation($annotation): PhpAnnotation
    {
        if ($annotation instanceof PhpAnnotation) {
            return $annotation;
        } elseif (is_string($annotation)) {
            return new PhpAnnotation(PhpAnnotation::NO_NAME, $annotation);
        } elseif (is_array($annotation) && array_key_exists('content', $annotation)) {
            return new PhpAnnotation(array_key_exists('name', $annotation) ? $annotation['name'] : PhpAnnotation::NO_NAME, $annotation['content']);
        } else {
            throw new InvalidArgumentException(sprintf('Annotation parameter "%s" is invalid', gettype($annotation)));
        }
    }

    /**
     * @param string[]|array[]|PhpAnnotation[] $annotations
     * @return bool
     */
    protected static function annotationsAreValid(array $annotations): bool
    {
        $valid = true;
        foreach ($annotations as $annotation) {
            $valid &= static::annotationIsValid($annotation);
        }
        return (bool) $valid;
    }

    /**
     * @param string|array|PhpAnnotation $annotation
     * @return bool
     */
    protected static function annotationIsValid($annotation): bool
    {
        return static::stringIsValid($annotation, false) || (is_array($annotation) && array_key_exists('content', $annotation)) || $annotation instanceof PhpAnnotation;
    }

    /**
     * @throws InvalidArgumentException
     * @param mixed $child
     * @return PhpAnnotationBlock
     */
    public function addChild($child): AbstractElement
    {
        if (!$this->childIsValid($child)) {
            return parent::addChild($child);
        }
        $this->children[] = $this->transformAnnotation($child);
        return $this;
    }

    public function getPhpDeclaration(): string
    {
        return '';
    }

    public function getChildrenTypes(): array
    {
        return [
            'array',
            'string',
            PhpAnnotation::class,
        ];
    }

    /**
     * Allows to generate content before children content is generated
     * @param int|null $indentation
     * @return string
     */
    public function getLineBeforeChildren(?int $indentation = null): string
    {
        return $this->getIndentedString(parent::OPEN_ANNOTATION, $indentation);
    }

    /**
     * Allows to generate content after children content is generated
     * @param int|null $indentation
     * @return string
     */
    public function getLineAfterChildren(?int $indentation = null): string
    {
        return $this->getIndentedString(parent::CLOSE_ANNOTATION, $indentation);
    }
}
