<?php

namespace My\Testing\NamespaceName;

use My\Testing\ParentNamespace\Model;
use My\Testing\ParentNamespace\Repository;
use My\Testing\ParentNamespace\Generator;
use My\Testing\ParentNamespace\Foo as FooType;

abstract class Foo extends stdClass
{
    /**
     * @var string
     */
    const FOO = 'theValue';
    /**
     * @var string
     */
    const BAR = 'theOtherValue';
    /**
     * @var int
     */
    public $bar = 1;
    /**
     * @var bool
     */
    public $sample = true;
    /**
     * This method is very useful
     * @date 2012-03-01
     * @return mixed
     */
    public function getMyValue($asString = true, $unusedParameter)
    {
    }
    /**
     * This method is very useless
     * @date 2012-03-01
     * @return void
     */
    public function uselessMethod($uselessParameter = null, $unusedParameter)
    {
    }
}
