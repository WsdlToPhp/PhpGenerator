<?php

namespace WsdlToPhp\PhpGenerator\Tests\Element;

use WsdlToPhp\PhpGenerator\Element\PhpAnnotation;
use WsdlToPhp\PhpGenerator\Tests\TestCase;

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

        $this->assertSame(" * This sample annotation is on one line This sample annotation is on one line This\n" .
                          " *  sample annotation is on one line This sample annotation is on one line This sam\n" .
                          " * ple annotation is on one line This sample annotation is on one line This sample \n" .
                          " * annotation is on one line", $annotation->getPhpDeclaration());
    }

    public function testGetSeveralLinesWithNamePhpDeclaration()
    {
        $annotation = new PhpAnnotation('description', str_repeat('This sample annotation is on one line ', 7));

        $this->assertSame(" * @description This sample annotation is on one line This sample annotation is on \n" .
                          " * one line This sample annotation is on one line This sample annotation is on one \n" .
                          " * line This sample annotation is on one line This sample annotation is on one line\n" .
                          " *  This sample annotation is on one line", $annotation->getPhpDeclaration());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddChildWithException()
    {
        $annotation = new PhpAnnotation('date', '2015-06-02');

        $annotation->addChild($annotation);
    }

    public function testToString()
    {
        $annotation = new PhpAnnotation(PhpAnnotation::NO_NAME, 'This sample annotation is on one line');

        $this->assertSame(' * This sample annotation is on one line', $annotation->toString());
    }
}
