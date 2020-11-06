<?php

namespace Pdmfc\DatabaseEnv\Tests;

use Orchestra\Testbench\TestCase;
use Pdmfc\DatabaseEnv\DatabaseEnvServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [DatabaseEnvServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
