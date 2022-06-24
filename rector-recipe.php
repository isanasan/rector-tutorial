<?php

declare(strict_types=1);

namespace RectorPrefix202206;

use PhpParser\Node\Expr\MethodCall;
use Rector\RectorGenerator\Provider\RectorRecipeProvider;
use Rector\RectorGenerator\ValueObject\Option;
use RectorPrefix202206\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $rectorRecipeConfiguration = [
        Option::PACKAGE => 'Naming',
        Option::NAME => 'RenameMethodCallRector',
        Option::NODE_TYPES => [MethodCall::class],
        Option::DESCRIPTION => '"something()" will be renamed to "somethingElse()"',
        Option::CODE_BEFORE => <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $this->something();
    }
}
CODE_SAMPLE,
        Option::CODE_AFTER => <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $this->somethingElse();
    }
}
CODE_SAMPLE,
    ];
    $services->set(RectorRecipeProvider::class)->arg('$rectorRecipeConfiguration', $rectorRecipeConfiguration);
};
