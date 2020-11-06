<?php

namespace Pdmfc\DatabaseEnv;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Pdmfc\DatabaseEnv\Skeleton\SkeletonClass
 */
class DatabaseEnvFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'database-env';
    }
}
