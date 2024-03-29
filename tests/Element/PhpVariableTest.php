<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Tests\Element;

use InvalidArgumentException;
use TypeError;
use WsdlToPhp\PhpGenerator\Element\PhpVariable;
use WsdlToPhp\PhpGenerator\Tests\TestCase;

/**
 * @internal
 * @coversDefaultClass
 */
class PhpVariableTest extends TestCase
{
    public function testGetPhpDeclarationNullValue()
    {
        $variable = new PhpVariable('foo');

        $this->assertSame('$foo = null;', $variable->getPhpDeclaration());
    }

    public function testGetPhpDeclarationTrueValue()
    {
        $variable = new PhpVariable('foo', true);

        $this->assertSame('$foo = true;', $variable->getPhpDeclaration());
    }

    public function testGetPhpDeclarationFalseValue()
    {
        $variable = new PhpVariable('foo', false);

        $this->assertSame('$foo = false;', $variable->getPhpDeclaration());
    }

    public function testGetPhpDeclarationStringOneValue()
    {
        $variable = new PhpVariable('foo', '1');

        $this->assertSame('$foo = \'1\';', $variable->getPhpDeclaration());
    }

    public function testGetPhpDeclarationNumberOneValue()
    {
        $variable = new PhpVariable('foo', 1);

        $this->assertSame('$foo = 1;', $variable->getPhpDeclaration());
    }

    public function testGetPhpDeclarationEmptyArrayValue()
    {
        $variable = new PhpVariable('foo', []);

        $this->assertSame('$foo = [];', $variable->getPhpDeclaration());
    }

    public function testGetPhpDeclarationArray()
    {
        $variable = new PhpVariable('foo', [
            '0',
            1,
        ]);

        $this->assertSame("\$foo = [\n  0 => '0',\n  1 => 1,\n];", $variable->getPhpDeclaration());
    }

    public function testGetPhpDeclarationNewInstance()
    {
        $variable = new PhpVariable('foo', 'new DOMDocument(\'1.0\', \'utf-8\')');

        $this->assertSame("\$foo = new DOMDocument('1.0', 'utf-8');", $variable->getPhpDeclaration());
    }

    public function testGetPhpDeclarationFunctoin()
    {
        $variable = new PhpVariable('foo', 'is_array(1)');

        $this->assertSame('$foo = is_array(1);', $variable->getPhpDeclaration());
    }

    public function testGetPhpDeclarationClassConstant()
    {
        $variable = new PhpVariable('foo', 'stdClass::BAR');

        $this->assertSame('$foo = stdClass::BAR;', $variable->getPhpDeclaration());
    }

    public function testGetPhpDeclarationConstant()
    {
        $variable = new PhpVariable('foo', '::XML_ELEMENT_NODE');

        $this->assertSame('$foo = XML_ELEMENT_NODE;', $variable->getPhpDeclaration());
    }

    public function testAddChild()
    {
        $this->expectException(InvalidArgumentException::class);

        $variable = new PhpVariable('Foo', 'bar');

        $variable->addChild(new PhpVariable('Bar', 'foo'));
    }

    public function testToStringNullValue()
    {
        $variable = new PhpVariable('foo');

        $this->assertSame('$foo = null;', $variable->toString());
    }

    public function testToStringMatchesStringCasting()
    {
        $variable = new PhpVariable('foo');

        $this->assertSame((string) $variable, $variable->toString());
    }

    public function testToStringStringNewsValue()
    {
        $variable = new PhpVariable('foo', 'news');

        $this->assertSame('$foo = \'news\';', $variable->toString());
    }

    public function testToStringFloatValue()
    {
        $variable = new PhpVariable('foo', 0.4);

        $this->assertSame('$foo = 0.4;', $variable->toString());
    }

    public function testCyrillic()
    {
        $variable = new PhpVariable('КонтактнаяИнформация', 0.4);

        $this->assertSame('$КонтактнаяИнформация = 0.4;', $variable->toString());
    }

    public function testé()
    {
        $é = 4;
        $this->assertEquals(4, $é);
    }

    public function testExceptionMessageOnName()
    {
        $this->expectException(TypeError::class);

        new PhpVariable(0);
    }
}
