<?php

declare (strict_types=1);
namespace RectorPrefix202206;

use Rector\Config\RectorConfig;
return static function (RectorConfig $rectorConfig) : void {
    $rectorConfig->rule(\Rector\RectorTutorial\Rector\ClassMethod\AddTestAnnotationRector::class);
};
