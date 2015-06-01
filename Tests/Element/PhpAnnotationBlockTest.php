<?php

namespace WsdlToPhp\PhpGenerator\Tests\Element;

use WsdlToPhp\PhpGenerator\Element\PhpAnnotation;
use WsdlToPhp\PhpGenerator\Element\PhpAnnotationBlock;
use WsdlToPhp\PhpGenerator\Tests\TestCase;

class PhpAnnotationBlockTest extends TestCase
{
    public function testGetOneLinePhpDeclaration()
    {
        $annotation = new PhpAnnotationBlock(array(
            'This sample annotation is on one line',
        ));

        $this->assertSame("/**\n * This sample annotation is on one line\n */", $annotation->getPhpDeclaration());
    }

    public function testGetOneLinePhpDeclarationWithName()
    {
        $annotation = new PhpAnnotationBlock(array(
            new PhpAnnotation('Author', 'PhpTeam'),
        ));

        $this->assertSame("/**\n * @Author PhpTeam\n */", $annotation->getPhpDeclaration());
    }

    public function testGetSeveralLinesPhpDeclaration()
    {
        $annotation = new PhpAnnotationBlock(array(
            str_repeat('This sample annotation is on one line ', 7),
        ));

        $this->assertSame("/**\n" .
                          " * This sample annotation is on one line This sample annotation is on one line This\n" .
                          " *  sample annotation is on one line This sample annotation is on one line This sam\n" .
                          " * ple annotation is on one line This sample annotation is on one line This sample \n" .
                          " * annotation is on one line\n" .
                          " */", $annotation->getPhpDeclaration());
    }

    public function testGetSeveralLinesWithNamePhpDeclaration()
    {
        $annotation = new PhpAnnotationBlock(array(
            new PhpAnnotation('description', str_repeat('This sample annotation is on one line ', 7)),
        ));

        $this->assertSame("/**\n" .
                          " * @description This sample annotation is on one line This sample annotation is on \n" .
                          " * one line This sample annotation is on one line This sample annotation is on one \n" .
                          " * line This sample annotation is on one line This sample annotation is on one line\n" .
                          " *  This sample annotation is on one line\n" .
                          " */", $annotation->getPhpDeclaration());
    }
}
