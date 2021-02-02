<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('vendor')
    ->exclude('tests/resources')
    ->in(__DIR__);

return PhpCsFixer\Config::create()
    ->setUsingCache(false)
    ->setRules(array(
        '@PhpCsFixer' => true,
    ))
    ->setFinder($finder);
