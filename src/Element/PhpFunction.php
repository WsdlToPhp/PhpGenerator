<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpFunction extends AbstractAccessRestrictedElement
{
    /**
     * @var string[]|PhpFunctionParameter[]
     */
    protected $parameters;
    /**
     * @param string $name
     * @param mixed[]|PhpFunctionParameter[] $parameters
     */
    public function __construct($name, array $parameters = array())
    {
        parent::__construct($name);
        $this->setParameters($parameters);
    }
    /**
     * @throws \InvalidArgumentException
     * @param array $parameters
     * @return PhpFunction
     */
    public function setParameters(array $parameters)
    {
        if (!self::parametersAreValid($parameters)) {
            throw new \InvalidArgumentException('Parameters are invalid');
        }
        $this->parameters = self::transformParameters($parameters);
        return $this;
    }
    /**
     * @param array $parameters
     * @return PhpFunctionParameter[]
     */
    public static function transformParameters(array $parameters)
    {
        $finalParameters = array();
        foreach ($parameters as $parameter) {
            $finalParameters[] = self::transformParameter($parameter);
        }
        return $finalParameters;
    }
    /**
     * @param mixed $parameter
     * @return PhpFunctionParameter
     */
    public static function transformParameter($parameter)
    {
        if ($parameter instanceof PhpFunctionParameter) {
            return $parameter;
        } elseif (is_array($parameter)) {
            return new PhpFunctionParameter($parameter['name'], array_key_exists('value', $parameter) ? $parameter['value'] : null, array_key_exists('type', $parameter) ? $parameter['type'] : null);
        }
        return new PhpFunctionParameter($parameter, PhpFunctionParameter::NO_VALUE);
    }
    /**
     * @param array $parameters
     * @return bool
     */
    public static function parametersAreValid(array $parameters)
    {
        $valid = true;
        foreach ($parameters as $parameter) {
            $valid &= self::parameterIsValid($parameter);
        }
        return (bool) $valid;
    }
    /**
     * @param string|array|PhpFunctionParameter $parameter
     * @return bool
     */
    public static function parameterIsValid($parameter)
    {
        return self::stringIsValid($parameter) || (is_array($parameter) && array_key_exists('name', $parameter)) || $parameter instanceof PhpFunctionParameter;
    }
    /**
     * @return string[]|PhpFunctionParameter[]
     */
    public function getParameters()
    {
        return $this->parameters;
    }
    /**
     * @return string
     */
    protected function getPhpParameters()
    {
        $parameters = $this->getParameters();
        $phpParameters = array();
        if (is_array($parameters) && !empty($parameters)) {
            foreach ($parameters as $parameter) {
                $phpParameters[] = $parameter->getPhpDeclaration();
            }
        }
        return implode(', ', $phpParameters);
    }
    /**
     * @see \WsdlToPhp\PhpGenerator\Element\AbstractElement::getPhpDeclaration()
     * @return string
     */
    public function getPhpDeclaration()
    {
        return sprintf('%sfunction %s(%s)', $this->getPhpAccess(), $this->getPhpName(), $this->getPhpParameters());
    }
    /**
     * indicates if the current element has accessibility constraint
     * @return bool
     */
    public function hasAccessibilityConstraint()
    {
        return false;
    }
    /**
     * defines authorized children element types
     * @return string[]
     */
    public function getChildrenTypes()
    {
        return array(
            'string',
            'WsdlToPhp\\PhpGenerator\\Element\\PhpAnnotationBlock',
            'WsdlToPhp\\PhpGenerator\\Element\\PhpVariable',
        );
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
        return true;
    }
}
