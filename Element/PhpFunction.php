<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpFunction extends AbstractAccessRestrictedElement
{
    /**
     * opening a function
     * @var string
     */
    const OPEN_BRACKET = '{';
    /**
     * closing a function
     * @var string
     */
    const CLOSE_BRACKET = '}';
    /**
     * @var string[]|PhpFunctionParameter[]
     */
    protected $parameters;
    /**
     * @param string $name
     * @param string $access
     * @param string[]|PhpFunctionParameter[] $parameters
     */
    public function __construct($name, $access = parent::ACCESS_PUBLIC, array $parameters = array())
    {
        parent::__construct($name, $access);
        $this->setParameters($parameters);
    }
    /**
     * @param array $parameters
     * @throws \InvalidArgumentException
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
        return (bool)$valid;
    }
    /**
     * @param string|array|PhpFunctionParameter $parameter
     * @return bool
     */
    public static function parameterIsValid($parameter)
    {
        return (is_string($parameter) && !empty($parameter)) || (is_array($parameter) && array_key_exists('name', $parameter)) || $parameter instanceof PhpFunctionParameter;
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
            'WsdlToPhp\\PhpGenerator\\Element\\PhpAnnotation',
            'WsdlToPhp\\PhpGenerator\\Element\\PhpVariable',
        );
    }
    /**
     * Allows to generate content before children content is generated
     * @param int $indentation
     * @return string
     */
    public function getLineBeforeChildren($indentation = null)
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
    public function getLineAfterChildren($indentation = null)
    {
        $this->setIndentation(($indentation === null ? $this->getIndentation() : $indentation) - 1);
        return $this->getIndentedString(self::CLOSE_BRACKET, $indentation);
    }
    /**
     * @return bool
     */
    public function canBeAlone()
    {
        return true;
    }
}
