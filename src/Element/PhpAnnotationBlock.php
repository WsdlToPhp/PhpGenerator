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
     * @param mixed $child
     *
     * @throws InvalidArgumentException
     */
    public function addChild($child): self
    {
        if (!$this->childIsValid($child)) {
            parent::addChild($child);

            return $this;
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
     * Allows to generate content before children content is generated.
     */
    public function getLineBeforeChildren(?int $indentation = null): string
    {
        return $this->getIndentedString(parent::OPEN_ANNOTATION, $indentation);
    }

    /**
     * Allows to generate content after children content is generated.
     */
    public function getLineAfterChildren(?int $indentation = null): string
    {
        return $this->getIndentedString(parent::CLOSE_ANNOTATION, $indentation);
    }

    /**
     * @param array[]|PhpAnnotation[]|string[] $annotations
     *
     * @throws InvalidArgumentException
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
     * @param array[]|PhpAnnotation[]|string[] $annotations
     *
     * @return PhpAnnotation[]
     */
    protected static function transformAnnotations(array $annotations): array
    {
        $finalAnnotations = [];
        foreach ($annotations as $annotation) {
            $finalAnnotations[] = static::transformAnnotation($annotation);
        }

        return $finalAnnotations;
    }

    /**
     * @param array|PhpAnnotation|string $annotation
     *
     * @throws InvalidArgumentException
     */
    protected static function transformAnnotation($annotation): PhpAnnotation
    {
        if ($annotation instanceof PhpAnnotation) {
            return $annotation;
        }
        if (is_string($annotation)) {
            return new PhpAnnotation(PhpAnnotation::NO_NAME, $annotation);
        }
        if (is_array($annotation) && array_key_exists('content', $annotation)) {
            return new PhpAnnotation(array_key_exists('name', $annotation) ? $annotation['name'] : PhpAnnotation::NO_NAME, $annotation['content']);
        }

        throw new InvalidArgumentException(sprintf('Annotation parameter "%s" is invalid', gettype($annotation)));
    }

    /**
     * @param array[]|PhpAnnotation[]|string[] $annotations
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
     * @param array|PhpAnnotation|string $annotation
     */
    protected static function annotationIsValid($annotation): bool
    {
        return static::stringIsValid($annotation, false) || (is_array($annotation) && array_key_exists('content', $annotation)) || $annotation instanceof PhpAnnotation;
    }
}
