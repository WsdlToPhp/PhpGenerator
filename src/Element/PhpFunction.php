<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Element;

use InvalidArgumentException;

class PhpFunction extends AbstractElement
{
    /**
     * @var PhpFunctionParameter[]|string[]
     */
    protected array $parameters;

    protected ?string $returnType;

    public function __construct(string $name, array $parameters = [], ?string $returnType = null)
    {
        parent::__construct($name);
        $this
            ->setParameters($parameters)
            ->setReturnType($returnType)
        ;
    }

    public function setParameters(array $parameters): self
    {
        if (!static::parametersAreValid($parameters)) {
            throw new InvalidArgumentException('Parameters are invalid');
        }

        $this->parameters = static::transformParameters($parameters);

        return $this;
    }

    public static function transformParameters(array $parameters): array
    {
        $finalParameters = [];
        foreach ($parameters as $parameter) {
            $finalParameters[] = static::transformParameter($parameter);
        }

        return $finalParameters;
    }

    public static function transformParameter($parameter): PhpFunctionParameter
    {
        if ($parameter instanceof PhpFunctionParameter) {
            return $parameter;
        }
        if (is_array($parameter)) {
            return new PhpFunctionParameter($parameter['name'], array_key_exists('value', $parameter) ? $parameter['value'] : null, array_key_exists('type', $parameter) ? $parameter['type'] : null);
        }

        return new PhpFunctionParameter($parameter, PhpFunctionParameter::NO_VALUE);
    }

    public static function parametersAreValid(array $parameters): bool
    {
        $valid = true;
        foreach ($parameters as $parameter) {
            $valid &= static::parameterIsValid($parameter);
        }

        return (bool) $valid;
    }

    /**
     * @param array|PhpFunctionParameter|string $parameter
     */
    public static function parameterIsValid($parameter): bool
    {
        return static::stringIsValid($parameter) || (is_array($parameter) && array_key_exists('name', $parameter)) || $parameter instanceof PhpFunctionParameter;
    }

    /**
     * @return PhpFunctionParameter[]|string[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function setReturnType(?string $returnType): self
    {
        $this->returnType = $returnType;

        return $this;
    }

    public function getReturnType(): ?string
    {
        return $this->returnType;
    }

    public function getPhpDeclaration(): string
    {
        return sprintf(
            'function %s(%s)%s',
            $this->getPhpName(),
            $this->getPhpParameters(),
            $this->returnType ? sprintf(': %s', $this->returnType) : ''
        );
    }

    public function getChildrenTypes(): array
    {
        return [
            'string',
            PhpAnnotationBlock::class,
            PhpVariable::class,
        ];
    }

    /**
     * Allows to indicate that children are contained by brackets,
     * in the case the method returns true, getBracketBeforeChildren
     * is called instead of getLineBeforeChildren and getBracketAfterChildren
     * is called instead of getLineAfterChildren, but be aware that these methods
     * call the two others.
     */
    public function useBracketsForChildren(): bool
    {
        return true;
    }

    protected function getPhpParameters(): string
    {
        $parameters = $this->getParameters();
        $phpParameters = [];
        if (is_array($parameters) && !empty($parameters)) {
            foreach ($parameters as $parameter) {
                $phpParameters[] = $parameter->getPhpDeclaration();
            }
        }

        return implode(', ', $phpParameters);
    }
}
