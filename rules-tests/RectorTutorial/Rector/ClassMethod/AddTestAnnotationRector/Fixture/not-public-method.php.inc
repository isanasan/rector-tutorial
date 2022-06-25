<?php

namespace Rector\Tests\RectorTutorial\Rector\ClassMethod\AddTestAnnotationRector\Fixture;

class NotPublicMethodTest extends \PHPUnit\Framework\TestCase
{
    protected function testProtected() : void
    {
    }

    private function testPrivate() : void
    {
    }
}
