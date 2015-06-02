<?php

namespace WsdlToPhp\PhpGenerator\Tests\Element;

use WsdlToPhp\PhpGenerator\Element\PhpVariable;

use WsdlToPhp\PhpGenerator\Element\PhpMethod;

use WsdlToPhp\PhpGenerator\Element\PhpAnnotationBlock;
use WsdlToPhp\PhpGenerator\Element\PhpConstant;
use WsdlToPhp\PhpGenerator\Element\PhpInterface;
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

        $this->assertSame("<?php\n\$foo = 1;", $file->toString());
    }
}
