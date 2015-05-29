<?php

namespace WsdlToPhp\PhpGenerator\Element;

class PhpClass extends AbstractElement
{
    const TYPE_ABSTRACT = 'abstract';
    const TYPE_INTERFACE = 'interface';
    /**
     * @var string
     */
    protected $type;
    /**
     * @param string $name
     * @param string $type
     */
    public function __construct($name, $type = null)
    {
        parent::__construct($name);
        $this->setType($type);
    }
    /**
     * @param string $type
     * @throws \InvalidArgumentException
     * @return PhpClass
     */
    public function setType($type)
    {
        if (!self::typeIsValid($type)) {
            throw new \InvalidArgumentException(sprintf('Type "%s" is invalid, provaide one of these types: %s', $type, implode(', ', self::getTypes())));
        }
        $this->type = $type;
        return $this;
    }
    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * @return string[]
     */
    public static function getTypes()
    {
        return array(
            self::TYPE_ABSTRACT,
            self::TYPE_INTERFACE,
        );
    }
    /**
     * @param sring $type
     * @return bool
     */
    public function typeIsValid($type)
    {
        return $type === null || in_array($type, self::getTypes(), true);
    }
    /**
     * @return string
     */
    protected function getPhpType()
    {
        return $this->getType() === null ? '' : sprintf(' %s', $this->getType());
    }
    /**
     * @return string
     */
    protected function getPhpDeclaration()
    {
        return sprintf('%s%s', $this->getPhpType(), parent::getPhpDeclaration());
    }
}
