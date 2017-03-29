<?php

namespace WsdlToPhp\PhpGenerator\Tests\Element;

use WsdlToPhp\PhpGenerator\Element\PhpClass;
use WsdlToPhp\PhpGenerator\Element\PhpFunction;
use WsdlToPhp\PhpGenerator\Element\PhpVariable;
use WsdlToPhp\PhpGenerator\Element\PhpMethod;
use WsdlToPhp\PhpGenerator\Element\PhpAnnotationBlock;
use WsdlToPhp\PhpGenerator\Element\PhpConstant;
use WsdlToPhp\PhpGenerator\Element\PhpFile;
use WsdlToPhp\PhpGenerator\Tests\TestCase;

class PhpFileTest extends TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testException()
    {
        $file = new PhpFile('foo');

        $file->addChild(new PhpMethod('Foo'));
    }

    public function testVariableToString()
    {
        $file = new PhpFile('foo');

        $file->addChild(new PhpVariable('foo', 1));

        $this->assertSame("<?php\n\$foo = 1;\n", $file->toString());
    }

    public function testConstantToString()
    {
        $file = new PhpFile('foo');

        $file->addChild(new PhpConstant('foo', 1));

        $this->assertSame("<?php\ndefine('foo', 1);\n", $file->toString());
    }

    public function testFunctionToString()
    {
        $file = new PhpFile('foo');

        $file->addChild(new PhpFunction('foo', array(
            'foo',
            'sample',
            'demo',
        )));

        $this->assertSame("<?php\nfunction foo(\$foo, \$sample, \$demo)\n{\n}\n", $file->toString());
    }

    public function testAnnotationBlockToString()
    {
        $file = new PhpFile('foo');

        $file->addChild(new PhpAnnotationBlock(array(
            'date is the key',
            'time is the core key',
        )));

        $this->assertSame("<?php\n/**\n * date is the key\n * time is the core key\n */\n", $file->toString());
    }

    public function testAnnotationClassMethodBlockToString()
    {
        $file = new PhpFile('foo');

        $file->addChild(new PhpAnnotationBlock(array(
            'date is the key',
            'time is the core key',
        )));

        $class = new PhpClass('Foo');
        $class->addChild(new PhpMethod('Bar'));
        $file->addChild($class);

        $this->assertSame("<?php\n/**\n * date is the key\n * time is the core key\n */\nclass Foo\n{\n    public function Bar()\n    {\n    }\n}\n", $file->toString());
    }

    public function testExceptionMessageOnName()
    {
        try {
            new PhpFile(0);
        } catch (\InvalidArgumentException $e) {
            $this->assertSame('Name "0" is invalid when instantiating PhpFile object', $e->getMessage());
        }
    }
}
