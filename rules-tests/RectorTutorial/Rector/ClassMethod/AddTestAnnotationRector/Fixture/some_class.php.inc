<?php

namespace Rector\Tests\RectorTutorial\Rector\ClassMethod\AddTestAnnotationRector\Fixture;

class SomeTest extends \PHPUnit\Framework\TestCase
{
    public function testSome() : void
    {
        // do test
    }
}

?>
-----
<?php

namespace Rector\Tests\RectorTutorial\Rector\ClassMethod\AddTestAnnotationRector\Fixture;

class SomeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function some() : void
    {
        // do test
    }
}

?>
