<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Tests\Element;

use WsdlToPhp\PhpGenerator\Element\PhpFunction;
use WsdlToPhp\PhpGenerator\Element\PhpAnnotation;
use WsdlToPhp\PhpGenerator\Element\PhpAnnotationBlock;
use WsdlToPhp\PhpGenerator\Tests\TestCase;

class PhpAnnotationBlockTest extends TestCase
{
    public function testGetOneLineToString()
    {
        $annotationBlock = new PhpAnnotationBlock([
            'This sample annotation is on one line',
        ]);

        $this->assertSame("/**\n * This sample annotation is on one line\n */", $annotationBlock->toString());
    }

    public function testGetOneLineToStringWithName()
    {
        $annotationBlock = new PhpAnnotationBlock([
            new PhpAnnotation('Author', 'PhpTeam'),
        ]);

        $this->assertSame("/**\n * @Author PhpTeam\n */", $annotationBlock->toString());
    }

    public function testGetSeveralLinesToString()
    {
        $annotationBlock = new PhpAnnotationBlock([
            str_repeat('This sample annotation is on one line ', 7),
        ]);

        $this->assertSame("/**\n" .
                          " * This sample annotation is on one line This sample annotation is on one line This\n" .
                          " * sample annotation is on one line This sample annotation is on one line This\n" .
                          " * sample annotation is on one line This sample annotation is on one line This\n" .
                          " * sample annotation is on one line\n" .
                          " */", $annotationBlock->toString());
    }

    public function testGetSeveralLinesWithNameToString()
    {
        $annotationBlock = new PhpAnnotationBlock([
            new PhpAnnotation('description', str_repeat('This sample annotation is on one line ', 7)),
        ]);

        $this->assertSame("/**\n" .
                          " * @description This sample annotation is on one line This sample annotation is on one line This sample annotation is on one line This sample annotation is on one line This sample annotation is on one line This sample annotation is on one line This sample annotation is on one line\n" .
                          " */", $annotationBlock->toString());
    }

    public function testAddChildString()
    {
        $annotationBlock = new PhpAnnotationBlock([
            'Foo',
        ]);

        $annotationBlock->addChild('bar');

        $this->assertCount(2, $annotationBlock->getChildren());
    }

    public function testAddChildAnnotation()
    {
        $annotationBlock = new PhpAnnotationBlock([
            'Foo',
        ]);

        $annotationBlock->addChild(new PhpAnnotation('date', '2015-06-02'));

        $this->assertCount(2, $annotationBlock->getChildren());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddChildWithException()
    {
        $annotationBlock = new PhpAnnotationBlock([
            'Foo',
        ]);

        $annotationBlock->addChild(new PhpFunction('test'));
    }

    public function testToStringSeveralLinesWithNameToString()
    {
        $annotationBlock = new PhpAnnotationBlock([
            new PhpAnnotation('description', str_repeat('This sample annotation is on one line ', 7)),
        ]);

        $this->assertSame("/**\n" .
                          " * @description This sample annotation is on one line This sample annotation is on one line This sample annotation is on one line This sample annotation is on one line This sample annotation is on one line This sample annotation is on one line This sample annotation is on one line\n" .
                          " */", $annotationBlock->toString());
    }

    public function testToStringChildAnnotation()
    {
        $annotationBlock = new PhpAnnotationBlock();

        $annotationBlock->addChild(new PhpAnnotation('Author', 'PhpTeam'));

        $this->assertSame("/**\n * @Author PhpTeam\n */", $annotationBlock->toString());
    }

    public function testToStringChildrendAnnotation()
    {
        $annotationBlock = new PhpAnnotationBlock();

        $annotationBlock
            ->addChild(new PhpAnnotation('date', '2015-01-01'))
            ->addChild(new PhpAnnotation('author', 'PhpTeam'))
            ->addChild('This annotation is useful!');

        $this->assertSame("/**\n * @date 2015-01-01\n * @author PhpTeam\n * This annotation is useful!\n */", $annotationBlock->toString());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddChildContentWithException()
    {
        $annotationBlock = new PhpAnnotationBlock();

        $annotationBlock->addChild([
            'Toto',
        ]);
    }

    public function testAddChildContentOk()
    {
        $annotationBlock = new PhpAnnotationBlock();

        $annotationBlock->addChild([
            'content' => 'The content',
            'name' => 'name',
        ]);

        $this->assertCount(1, $annotationBlock->getChildren());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetConstructWithException()
    {
        new PhpAnnotationBlock([
            new PhpFunction('Bar'),
        ]);
    }
}
