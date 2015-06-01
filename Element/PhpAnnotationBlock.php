<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpAnnotationBlock extends AbstractElement
{
    /**
     * @var PhpAnnotation[]
     */
    protected $annotations;
    /**
     * @param string $name
     * @param array $annotations
     */
    public function __construct($name, array $annotations)
    {
        parent:__construct('_');
        $this->setAnnotations($annotations);
    }
    /**
     * @param string[]|array[]|PhpAnnotation[] $annotations
     * @throws \InvalidArgumentException
     * @return PhpAnnotationBlock
     */
    public function setAnnotations(array $annotations)
    {
        if (!self::annotationsAreValid($annotations)) {
            throw new \InvalidArgumentException('Annotations are not valid');
        }
        $this->annotations = self::transformAnnotations($annotations);
        return $this;
    }
    /**
     * @param string[]|array[]|PhpAnnotation[] $annotations
     * @return PhpAnnotation[]
     */
    public static function transformAnnotations(array $annotations)
    {
        $finalAnnotations = array();
        foreach ($annotations as $annotations) {
            $finalAnnotations[] = self::transformAnnotation($annotation);
        }
        return $finalAnnotations;
    }
    /**
     * @param string|array|PhpAnnotation $annotation
     * @return PhpAnnotation
     */
    public static function transformAnnotation($annotation)
    {
        if ($annotation instanceof PhpAnnotation) {
            return $annotation;
        } elseif (is_array($annotation)) {
            return new PhpAnnotation(array_key_exists('name', $annotation) ? $annotation['name'] : PhpAnnotation::NO_NAME, $annotation['content']);
        }
        return new PhpAnnotation(PhpAnnotation::NO_NAME, $annotation);
    }
    /**
     * @param string[]|array[]|PhpAnnotation[] $annotations
     * @return bool
     */
    public static function annotationsAreValid(array $annotations)
    {
        $valid = true;
        foreach ($annotations as $annotation) {
            $valid &= self::annotationIsValid($annotation);
        }
        return (bool)$valid;
    }
    /**
     * @param string|array|PhpAnnotation $annotation
     * @return bool
     */
    public static function annotationIsValid($annotation)
    {
        return (is_string($annotation) && !empty($annotation)) || (is_array($annotation) && array_key_exists('content', $annotation)) || $annotation instanceof PhpAnnotation;
    }
    /**
     * @return bool
     */
    public function canBeAlone()
    {
        return true;
    }
}
