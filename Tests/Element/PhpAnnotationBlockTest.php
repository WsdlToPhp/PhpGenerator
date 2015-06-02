<?php

namespace WsdlToPhp\PhpGenerator\Tests\Element;

use WsdlToPhp\PhpGenerator\Element\PhpFunction;
use WsdlToPhp\PhpGenerator\Element\PhpAnnotation;
use WsdlToPhp\PhpGenerator\Element\PhpAnnotationBlock;
use WsdlToPhp\PhpGenerator\Tests\TestCase;

class PhpAnnotationBlockTest extends TestCase
{
    public function testGetOneLinePhpDeclaration()
    {
        $annotationBlock = new PhpAnnotationBlock(array(
            'This sample annotation is on one line',
        ));

        $this->assertSame("/**\n * This sample annotation is on one line\n */", $annotationBlock->getPhpDeclaration());
    }

    public function testGetOneLinePhpDeclarationWithName()
    {
        $annotationBlock = new PhpAnnotationBlock(array(
            new PhpAnnotation('Author', 'PhpTeam'),
        ));

        $this->assertSame("/**\n * @Author PhpTeam\n */", $annotationBlock->getPhpDeclaration());
    }

    public function testGetSeveralLinesPhpDeclaration()
    {
        $annotationBlock = new PhpAnnotationBlock(array(
            str_repeat('This sample annotation is on one line ', 7),
        ));

        $this->assertSame("/**\n" .
                          " * This sample annotation is on one line This sample annotation is on one line This\n" .
                          " *  sample annotation is on one line This sample annotation is on one line This sam\n" .
                          " * ple annotation is on one line This sample annotation is on one line This sample \n" .
                          " * annotation is on one line\n" .
                          " */", $annotationBlock->getPhpDeclaration());
    }

    public function testGetSeveralLinesWithNamePhpDeclaration()
    {
        $annotationBlock = new PhpAnnotationBlock(array(
            new PhpAnnotation('description', str_repeat('This sample annotation is on one line ', 7)),
        ));

        $this->assertSame("/**\n" .
                          " * @description This sample annotation is on one line This sample annotation is on \n" .
                          " * one line This sample annotation is on one line This sample annotation is on one \n" .
                          " * line This sample annotation is on one line This sample annotation is on one line\n" .
                          " *  This sample annotation is on one line\n" .
                          " */", $annotationBlock->getPhpDeclaration());
    }

    public function testAddChildString()
    {
        $annotationBlock = new PhpAnnotationBlock(array(
            'Foo',
        ));

        $annotationBlock->addChild('bar');

        $this->assertCount(1, $annotationBlock->getChildren());
    }

    public function testAddChildAnnotation()
    {
        $annotationBlock = new PhpAnnotationBlock(array(
            'Foo',
        ));

        $annotationBlock->addChild(new PhpAnnotation('date', '2015-06-02'));

        $this->assertCount(1, $annotationBlock->getChildren());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddChildWithException()
    {
        $annotationBlock = new PhpAnnotationBlock(array(
            'Foo',
        ));

        $annotationBlock->addChild(new PhpFunction('test'));
    }

    public function testToStringSeveralLinesWithNamePhpDeclaration()
    {
        $annotationBlock = new PhpAnnotationBlock(array(
            new PhpAnnotation('description', str_repeat('This sample annotation is on one line ', 7)),
        ));

        $this->assertSame("/**\n" .
                          " * @description This sample annotation is on one line This sample annotation is on \n" .
                          " * one line This sample annotation is on one line This sample annotation is on one \n" .
                          " * line This sample annotation is on one line This sample annotation is on one line\n" .
                          " *  This sample annotation is on one line\n" .
                          " */", $annotationBlock->toString());
    }
}
