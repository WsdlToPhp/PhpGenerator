<?php

namespace WsdlToPhp\PhpGenerator\Component;

use WsdlToPhp\PhpGenerator\Element\PhpAnnotationBlock;

use WsdlToPhp\PhpGenerator\Element\PhpProperty;

use WsdlToPhp\PhpGenerator\Element\PhpConstant;

use WsdlToPhp\PhpGenerator\Element\PhpMethod;

use WsdlToPhp\PhpGenerator\Element\PhpClass as PhpClassElement;
use WsdlToPhp\PhpGenerator\Element\PhpAnnotationBlock as PhpAnnotationBlockElement;
use WsdlToPhp\PhpGenerator\Element\PhpProperty as PhpPropertyElement;
use WsdlToPhp\PhpGenerator\Element\PhpConstant as PhpConstantElement;
use WsdlToPhp\PhpGenerator\Element\PhpMethod as PhpMethodElement;

class PhpClass extends AbstractComponent
{
    /**
     * @var array
     */
    protected $uses = array();
    /**
     * @var PhpClassElement
     */
    protected $class;
    /**
     * @var string
     */
    protected $namespace = '';
    /**
     * @param string $name
     * @param string $abstract
     * @param string $extends
     * @param array $interfaces
     */
    public function __construct($name, $abstract = false, $extends = null, array $interfaces = array())
    {
        $this->class = new PhpClassElement($name, $abstract, $extends, $interfaces);
    }
    /**
     * @param string $use
     * @param string $as
     * @return PhpClass
     */
    public function addUse($use, $as = null)
    {
        $expression = empty($as) ? "use %1\$s;%3\$s" : "use %1\$s as %2\$s;%3\$s";
        $this->uses[] = sprintf($expression, $use, $as, self::BREAK_LINE_CHAR);
        return $this;
    }
    /**
     * @param PhpMethod $method
     * @return PhpClass
     */
    public function addMethodElement(PhpMethodElement $method)
    {
        $this->class->addChild($method);
        return $this;
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\PhpMethod::__construct()
     * @param string $name
     * @param array $parameters
     * @param string $access
     * @param bool $abstract
     * @param bool $static
     * @param bool $final
     * @param bool $hasBody
     * @return PhpClass
     */
    public function addMethod($name, array $parameters = array(), $access = PhpMethod::ACCESS_PUBLIC, $abstract = false, $static = false, $final = false, $hasBody = true)
    {
        return $this->addMethodElement(new PhpMethod($name, $parameters, $access, $abstract, $static, $final, $hasBody));
    }
    /**
     * @param PhpConstant $constant
     * @return PhpClass
     */
    public function addConstantElement(PhpConstantElement $constant)
    {
        if (!$constant->getClass() instanceof PhpClassElement) {
            $constant->setClass($this->class);
        }
        $this->class->addChild($constant);
        return $this;
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\PhpConstant::__construct()
     * @param string $name
     * @param mixed $value
     * @param PhpClass $class
     * @return PhpClass
     */
    public function addConstant($name, $value = null, $class = null)
    {
        return $this->addConstantElement(new PhpConstant($name, $value, $class));
    }
    /**
     * @param string $namespace
     * @return PhpClass
     */
    public function setNamespace($namespace)
    {
        $this->namespace = sprintf("namespace %s;%s", $namespace, self::BREAK_LINE_CHAR);
        return $this;
    }
    /**
     * @param PhpProperty $property
     * @return PhpClass
     */
    public function addPropertyElement(PhpPropertyElement $property)
    {
        $this->class->addChild($property);
        return $this;
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\PhpProperty::__construct()
     * @param string $name
     * @param string $value
     * @param string $access
     * @return PhpClass
     */
    public function addProperty($name, $value = null, $access = PhpProperty::ACCESS_PUBLIC)
    {
        return $this->addPropertyElement(new PhpProperty($name, $value, $access));
    }
    /**
     * @param PhpAnnotationBlock $annotationBlock
     * @return PhpClass
     */
    public function addAnnotationBlockElement(PhpAnnotationBlockElement $annotationBlock)
    {
        $this->class->addChild($annotationBlock);
        return $this;
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\PhpAnnotationBlock::__construct()
     * @param array $annotations
     * @return PhpClass
     */
    public function addAnnotationBlock($annotations)
    {
        return $this->addAnnotationBlockElement(new PhpAnnotationBlock(is_array($annotations) ? $annotations : array(
            $annotations,
        )));
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Component\AbstractComponent::getElements()
     * @return AbstractElement[]|string[]
     */
    public function getElements()
    {
        $elements = array();
        if (!empty($this->namespace)) {
            $elements[] = $this->namespace;
            $elements[] = self::BREAK_LINE_CHAR;
        }
        if (!empty($this->uses)) {
            foreach ($this->uses as $use) {
                $elements[] = $use;
            }
            $elements[] = self::BREAK_LINE_CHAR;
        }
        $elements[] = $this->class;
        return $elements;
    }
}
