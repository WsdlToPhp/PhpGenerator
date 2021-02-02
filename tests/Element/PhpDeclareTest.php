<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Tests\Element;

use InvalidArgumentException;
use TypeError;
use WsdlToPhp\PhpGenerator\Element\PhpClass;
use WsdlToPhp\PhpGenerator\Element\PhpDeclare;
use WsdlToPhp\PhpGenerator\Tests\TestCase;

/**
 * @internal
 * @coversDefaultClass
 */
class PhpDeclareTest extends TestCase
{
    public function testConstructWithInvalidStringNameMustThrowAnException()
    {
        $this->expectException(InvalidArgumentException::class);

        new PhpDeclare('my_directive');
    }

    public function testConstructWithInvalidIntNameMustThrowAnException()
    {
        $this->expectException(TypeError::class);

        new PhpDeclare(0);
    }

    public function testConstructWithInvalidValueMustThrowAnException()
    {
        $this->expectException(InvalidArgumentException::class);

        new PhpDeclare(PhpDeclare::DIRECTIVE_STRICT_TYPES, []);
    }

    public function testAddChildMustThrowAnExceptionForInvalidChildType()
    {
        $this->expectException(InvalidArgumentException::class);

        $phpDeclare = new PhpDeclare(PhpDeclare::DIRECTIVE_STRICT_TYPES);

        $phpDeclare->addChild(new PhpClass('foo'));
    }

    public function testAddChildMustThrowAnExceptionForSameDirectiveNameChild()
    {
        $this->expectException(InvalidArgumentException::class);

        $phpDeclare = new PhpDeclare(PhpDeclare::DIRECTIVE_STRICT_TYPES);

        $phpDeclare->addChild(new PhpDeclare(PhpDeclare::DIRECTIVE_STRICT_TYPES));
    }

    public function testAddChildMustPass()
    {
        $phpDeclare = new PhpDeclare(PhpDeclare::DIRECTIVE_STRICT_TYPES);

        $phpDeclare->addChild(new PhpDeclare(PhpDeclare::DIRECTIVE_ENCODING));

        $this->assertCount(1, $phpDeclare->getChildren());
    }

    public function testConstructWithValidNameMustPass()
    {
        $phpDeclare = new PhpDeclare($name = PhpDeclare::DIRECTIVE_STRICT_TYPES);

        $this->assertSame($name, $phpDeclare->getName());
    }

    public function testToStringWithOneDirectiveWithoutValueMustReturnAnEmptyString()
    {
        $phpDeclare = new PhpDeclare($name = PhpDeclare::DIRECTIVE_STRICT_TYPES);

        $this->assertEmpty($phpDeclare->toString());
    }

    public function testToStringWithOneDirectiveWithValueMustReturnTheDirective()
    {
        $phpDeclare = new PhpDeclare($name = PhpDeclare::DIRECTIVE_STRICT_TYPES, 1);

        $this->assertSame('declare(strict_types=1);', $phpDeclare->getPhpDeclaration());
    }

    public function testToStringWithTwoDirectivesWithValueMustReturnTheDirective()
    {
        $phpDeclare = new PhpDeclare($name = PhpDeclare::DIRECTIVE_STRICT_TYPES, 1);
        $phpDeclare->addChild(new PhpDeclare($name = PhpDeclare::DIRECTIVE_ENCODING, 'UTF-8'));

        $this->assertSame('declare(strict_types=1, encoding=\'UTF-8\');', $phpDeclare->getPhpDeclaration());
    }

    public function testToStringWithThreeDirectivesWithValueMustReturnTheDirective()
    {
        $phpDeclare = new PhpDeclare($name = PhpDeclare::DIRECTIVE_STRICT_TYPES, 1);
        $phpDeclare
            ->addChild(new PhpDeclare($name = PhpDeclare::DIRECTIVE_ENCODING, 'UTF-8'))
            ->addChild(new PhpDeclare($name = PhpDeclare::DIRECTIVE_TICKS, 0))
        ;

        $this->assertSame('declare(strict_types=1, encoding=\'UTF-8\', ticks=0);', $phpDeclare->getPhpDeclaration());
    }
}
