<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Tests\Element;

use InvalidArgumentException;
use TypeError;
use WsdlToPhp\PhpGenerator\Element\PhpAnnotation;
use WsdlToPhp\PhpGenerator\Tests\TestCase;

/**
 * @internal
 * @coversDefaultClass
 */
class PhpAnnotationTest extends TestCase
{
    public function testGetOneLinePhpDeclaration()
    {
        $annotation = new PhpAnnotation(PhpAnnotation::NO_NAME, 'This sample annotation is on one line');

        $this->assertSame(' * This sample annotation is on one line', $annotation->getPhpDeclaration());
    }

    public function testGetOneLinePhpDeclarationWithName()
    {
        $annotation = new PhpAnnotation('author', 'PhpTeam');

        $this->assertSame(' * @author PhpTeam', $annotation->getPhpDeclaration());
    }

    public function testGetSeveralLinesPhpDeclaration()
    {
        $annotation = new PhpAnnotation(PhpAnnotation::NO_NAME, str_repeat('This sample annotation is on one line ', 7));

        $this->assertSame(" * This sample annotation is on one line This sample annotation is on one line This\n".
                          " * sample annotation is on one line This sample annotation is on one line This\n".
                          " * sample annotation is on one line This sample annotation is on one line This\n".
                          ' * sample annotation is on one line', $annotation->getPhpDeclaration());
    }

    public function testGetSeveralLinesWithNamePhpDeclaration()
    {
        $annotation = new PhpAnnotation('description', str_repeat('This sample annotation is on one line ', 7));

        $this->assertSame(' * @description This sample annotation is on one line This sample annotation is on one line This sample annotation is on one line This sample annotation is on one line This sample annotation is on one line This sample annotation is on one line This sample annotation is on one line', $annotation->getPhpDeclaration());
    }

    public function testGetSeveralLinesLargerWithNamePhpDeclaration()
    {
        $annotation = new PhpAnnotation('description', str_repeat('This sample annotation is on one line ', 7));

        $this->assertSame(' * @description This sample annotation is on one line This sample annotation is on one line This sample annotation is on one line This sample annotation is on one line This sample annotation is on one line This sample annotation is on one line This sample annotation is on one line', $annotation->getPhpDeclaration());
    }

    public function testAddChildWithException()
    {
        $this->expectException(InvalidArgumentException::class);

        $annotation = new PhpAnnotation('date', '2015-06-02');

        $annotation->addChild($annotation);
    }

    public function testToString()
    {
        $annotation = new PhpAnnotation(PhpAnnotation::NO_NAME, 'This sample annotation is on one line');

        $this->assertSame(' * This sample annotation is on one line', $annotation->toString());
    }

    public function testToStringMatchesStringCasting()
    {
        $annotation = new PhpAnnotation(PhpAnnotation::NO_NAME, 'This sample annotation is on one line');

        $this->assertSame((string) $annotation, $annotation->toString());
    }

    public function testHasContent()
    {
        $annotation = new PhpAnnotation(PhpAnnotation::NO_NAME, 'This sample annotation is on one line');

        $this->assertTrue($annotation->hasContent());
    }

    public function testExceptionMessageOnName()
    {
        $this->expectException(TypeError::class);

        new PhpAnnotation(0, '');
    }
}
