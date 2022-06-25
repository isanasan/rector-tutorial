<?php

namespace Rector\Tests\RectorTutorial\Rector\ClassMethod\AddTestAnnotationRector\Fixture;

class NotTestPrefix extends \PHPUnit\Framework\TestCase
{
    public function noPrefix() : void
    {
    }
}
