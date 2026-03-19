<?php

namespace SmartDato\DhlParcel\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use SmartDato\DhlParcel\DhlParcelServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            DhlParcelServiceProvider::class,
        ];
    }
}
