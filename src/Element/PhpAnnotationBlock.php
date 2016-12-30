<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpAnnotationBlock extends AbstractElement
{
    /**
     * @param array $annotations
     */
    public function __construct(array $annotations = array())
    {
        parent::__construct('_');
        $this->setAnnotations($annotations);
    }
    /**
     * @throws \InvalidArgumentException
     * @param string[]|array[]|PhpAnnotation[] $annotations
     * @return PhpAnnotationBlock
     */
    protected function setAnnotations(array $annotations)
    {
        if (!self::annotationsAreValid($annotations)) {
            throw new \InvalidArgumentException('Annotations are not valid');
        }
        $this->children = self::transformAnnotations($annotations);
        return $this;
    }
    /**
     * @param string[]|array[]|PhpAnnotation[] $annotations
     * @return PhpAnnotation[]
     */
    protected static function transformAnnotations(array $annotations)
    {
        $finalAnnotations = array();
        foreach ($annotations as $annotation) {
            $finalAnnotations[] = self::transformAnnotation($annotation);
        }
        return $finalAnnotations;
    }
    /**
     * @throws \InvalidArgumentException
     * @param string|array|PhpAnnotation $annotation
     * @return PhpAnnotation
     */
    protected static function transformAnnotation($annotation)
    {
        if ($annotation instanceof PhpAnnotation) {
            return $annotation;
        } elseif (is_string($annotation)) {
            return new PhpAnnotation(PhpAnnotation::NO_NAME, $annotation);
        } elseif (is_array($annotation) && array_key_exists('content', $annotation)) {
            return new PhpAnnotation(array_key_exists('name', $annotation) ? $annotation['name'] : PhpAnnotation::NO_NAME, $annotation['content']);
        } else {
            throw new \InvalidArgumentException(sprintf('Annotation parameter "%s" is invalid', gettype($annotation)));
        }
    }
    /**
     * @param string[]|array[]|PhpAnnotation[] $annotations
     * @return bool
     */
    protected static function annotationsAreValid(array $annotations)
    {
        $valid = true;
        foreach ($annotations as $annotation) {
            $valid &= self::annotationIsValid($annotation);
        }
        return (bool) $valid;
    }
    /**
     * @param string|array|PhpAnnotation $annotation
     * @return bool
     */
    protected static function annotationIsValid($annotation)
    {
        return self::stringIsValid($annotation, false) || (is_array($annotation) && array_key_exists('content', $annotation)) || $annotation instanceof PhpAnnotation;
    }
    /**
     * @throws \InvalidArgumentException
     * @param mixed $child
     * @return PhpAnnotationBlock
     */
    public function addChild($child)
    {
        if (!$this->childIsValid($child)) {
            return parent::addChild($child);
        }
        $this->children[] = $this->transformAnnotation($child);
        return $this;
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\AbstractElement::getPhpDeclaration()
     * @return string
     */
    public function getPhpDeclaration()
    {
        return '';
    }
    /**
     * defines authorized children element types
     * @return string[]
     */
    public function getChildrenTypes()
    {
        return array(
            'array',
            'string',
            'WsdlToPhp\\PhpGenerator\\Element\\PhpAnnotation',
        );
    }
    /**
     * Allows to generate content before children content is generated
     * @param int $indentation
     * @return string
     */
    public function getLineBeforeChildren($indentation = null)
    {
        return $this->getIndentedString(parent::OPEN_ANNOTATION, $indentation);
    }
    /**
     * Allows to generate content after children content is generated
     * @param int $indentation
     * @return string
     */
    public function getLineAfterChildren($indentation = null)
    {
        return $this->getIndentedString(parent::CLOSE_ANNOTATION, $indentation);
    }
}
