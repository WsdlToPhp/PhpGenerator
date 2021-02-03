<?php

declare(strict_types=1);

namespace WsdlToPhp\PhpGenerator\Tests\Component;

use InvalidArgumentException;
use WsdlToPhp\PhpGenerator\Component\AbstractComponent as AbstractComponentComponent;
use WsdlToPhp\PhpGenerator\Tests\TestCase;

/**
 * @internal
 * @coversDefaultClass
 */
class AbstractComponent extends TestCase
{
    public function assertSameContent($function, AbstractComponentComponent $component)
    {
        $class = get_called_class();
        $filename = sprintf(__DIR__.'/../resources/%s_%s.php', implode('', array_slice(explode('\\', $class), -1, 1)), substr($function, 4));
        if (!is_file($filename)) {
            throw new InvalidArgumentException(sprintf('Unable to locate "%s" content file for function "%s::%s"', $filename, $class, $function));
        }

        // uncomment to write valid content into tested file
        // file_put_contents($filename, $component->toString());

        $this->assertSame(file_get_contents($filename), $component->toString());
        $this->assertSame($component->toString(), (string) $component);
    }
}
