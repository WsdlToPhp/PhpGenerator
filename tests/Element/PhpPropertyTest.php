<?php

namespace WsdlToPhp\PhpGenerator\Tests\Element;

use WsdlToPhp\PhpGenerator\Element\PhpVariable;
use WsdlToPhp\PhpGenerator\Element\PhpProperty;
use WsdlToPhp\PhpGenerator\Tests\TestCase;

class PhpPropertyTest extends TestCase
{
    public function testPublicGetPhpDeclarationNullValue()
    {
        $property = new PhpProperty('foo');

        $this->assertSame('public $foo = null;', $property->getPhpDeclaration());
    }

    public function testPublicGetPhpDeclarationTrueValue()
    {
        $property = new PhpProperty('foo', true);

        $this->assertSame('public $foo = true;', $property->getPhpDeclaration());
    }

    public function testPublicGetPhpDeclarationFalseValue()
    {
        $property = new PhpProperty('foo', false);

        $this->assertSame('public $foo = false;', $property->getPhpDeclaration());
    }

    public function testPublicGetPhpDeclarationStringOneValue()
    {
        $property = new PhpProperty('foo', '1');

        $this->assertSame('public $foo = \'1\';', $property->getPhpDeclaration());
    }

    public function testPublicGetPhpDeclarationNumberOneValue()
    {
        $property = new PhpProperty('foo', 1);

        $this->assertSame('public $foo = 1;', $property->getPhpDeclaration());
    }

    public function testPublicGetPhpDeclarationArray()
    {
        $property = new PhpProperty('foo', array(
            '0',
            1,
        ));

        $this->assertSame("public \$foo = array (\n  0 => '0',\n  1 => 1,\n);", $property->getPhpDeclaration());
    }

    public function testPublicGetPhpDeclarationNewInstance()
    {
        $property = new PhpProperty('foo', 'new DOMDocument(\'1.0\', \'utf-8\')');

        $this->assertSame("public \$foo = new DOMDocument('1.0', 'utf-8');", $property->getPhpDeclaration());
    }

    public function testPublicGetPhpDeclarationFunctoin()
    {
        $property = new PhpProperty('foo', 'is_array(1)');

        $this->assertSame("public \$foo = is_array(1);", $property->getPhpDeclaration());
    }

    public function testPrivateGetPhpDeclarationNullValue()
    {
        $property = new PhpProperty('foo', null, PhpProperty::ACCESS_PRIVATE);

        $this->assertSame('private $foo = null;', $property->getPhpDeclaration());
    }

    public function testProtectedGetPhpDeclarationNullValue()
    {
        $property = new PhpProperty('foo', null, PhpProperty::ACCESS_PROTECTED);

        $this->assertSame('protected $foo = null;', $property->getPhpDeclaration());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddChild()
    {
        $property = new PhpProperty('Foo');

        $property->addChild(new PhpVariable('Bar'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetAccess()
    {
        $property = new PhpProperty('Foo');

        $property->setAccess(' public');
    }

    public function testExceptionMessageOnName()
    {
        try {
            new PhpProperty(0);
        } catch (\InvalidArgumentException $e) {
            $this->assertSame('Name "0" is invalid when instantiating PhpProperty object', $e->getMessage());
        }
    }
}
