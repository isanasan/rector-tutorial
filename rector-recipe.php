<?php

declare(strict_types=1);

namespace RectorPrefix202206;

use PhpParser\Node\Stmt\ClassMethod;
use Rector\RectorGenerator\Provider\RectorRecipeProvider;
use Rector\RectorGenerator\ValueObject\Option;
use RectorPrefix202206\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $rectorRecipeConfiguration = [
        Option::PACKAGE => 'RectorTutorial',
        Option::NAME => 'AddTestAnnotationRector',
        Option::NODE_TYPES => [ClassMethod::class],
        Option::DESCRIPTION => 'Rector Tutorial',
        Option::CODE_BEFORE => <<<'CODE_SAMPLE'
class SomeTest extends \PHPUnit\Framework\TestCase
{
    public function testSome() : void
    {
        // do test
    }
}
CODE_SAMPLE,
        Option::CODE_AFTER => <<<'CODE_SAMPLE'
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
CODE_SAMPLE,
    ];
    $services->set(RectorRecipeProvider::class)->arg('$rectorRecipeConfiguration', $rectorRecipeConfiguration);
};

