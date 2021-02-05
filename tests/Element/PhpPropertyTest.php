<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Tests\Element;

use DateTime;
use InvalidArgumentException;
use TypeError;
use WsdlToPhp\PhpGenerator\Element\PhpProperty;
use WsdlToPhp\PhpGenerator\Element\PhpVariable;
use WsdlToPhp\PhpGenerator\Tests\TestCase;

/**
 * @internal
 * @coversDefaultClass
 */
class PhpPropertyTest extends TestCase
{
    public function testPublicGetPhpDeclarationNoValueEmptyAccess()
    {
        $property = new PhpProperty('foo', PhpProperty::NO_VALUE, '');

        $this->assertSame('$foo;', $property->getPhpDeclaration());
    }

    public function testPublicGetPhpDeclarationNoValue()
    {
        $property = new PhpProperty('foo', PhpProperty::NO_VALUE);

        $this->assertSame('public $foo;', $property->getPhpDeclaration());
    }

    public function testPublicGetPhpDeclarationNullValue()
    {
        $property = new PhpProperty('foo');

        $this->assertSame('public $foo = null;', $property->getPhpDeclaration());
    }

    public function testPublicGetPhpDeclarationBoolTypeNoValue()
    {
        $property = new PhpProperty('foo', PhpProperty::NO_VALUE, PhpProperty::ACCESS_PUBLIC, PhpProperty::TYPE_BOOL);

        $this->assertSame('public bool $foo;', $property->getPhpDeclaration());
    }

    public function testPublicGetPhpDeclarationDateTimeProperty()
    {
        $property = new PhpProperty('date', PhpProperty::NO_VALUE, PhpProperty::ACCESS_PUBLIC, DateTime::class);

        $this->assertSame('public DateTime $date;', $property->getPhpDeclaration());
    }

    public function testPublicGetPhpDeclarationNoTypeTrueValue()
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
        $property = new PhpProperty('foo', [
            '0',
            1,
        ]);

        $this->assertSame("public \$foo = [\n  0 => '0',\n  1 => 1,\n];", $property->getPhpDeclaration());
    }

    public function testPublicGetPhpDeclarationNewInstance()
    {
        $property = new PhpProperty('foo', 'new DOMDocument(\'1.0\', \'utf-8\')');

        $this->assertSame("public \$foo = new DOMDocument('1.0', 'utf-8');", $property->getPhpDeclaration());
    }

    public function testPublicGetPhpDeclarationFunctoin()
    {
        $property = new PhpProperty('foo', 'is_array(1)');

        $this->assertSame('public $foo = is_array(1);', $property->getPhpDeclaration());
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

    public function testAddChild()
    {
        $this->expectException(InvalidArgumentException::class);

        $property = new PhpProperty('Foo');

        $property->addChild(new PhpVariable('Bar'));
    }

    public function testSetAccess()
    {
        $this->expectException(InvalidArgumentException::class);

        $property = new PhpProperty('Foo');

        $property->setAccess(' public');
    }

    public function testExceptionMessageOnName()
    {
        $this->expectException(TypeError::class);

        new PhpProperty(0);
    }
}
