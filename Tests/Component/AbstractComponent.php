<?php

namespace WsdlToPhp\PhpGenerator\Tests\Component;

use WsdlToPhp\PhpGenerator\Tests\TestCase;
use WsdlToPhp\PhpGenerator\Component\AbstractComponent as AbstractComponentComponent;

class AbstractComponent extends TestCase
{
    public function assertSameContent($function, AbstractComponentComponent $component)
    {
        $class = get_called_class();
        $filename = sprintf(__DIR__ . '/../resources/%s_%s.php', implode('', array_slice(explode('\\', $class), -1, 1)), substr($function, 4));
        if (!is_file($filename)) {
            throw new \InvalidArgumentException(sprintf('Unable to locate "%s" content file for function "%s::%s"', $filename, $class, $function));
        }
        $this->assertSame(file_get_contents($filename), $component->toString());
    }
}
