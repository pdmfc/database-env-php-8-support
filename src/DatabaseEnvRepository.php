<?php

namespace Pdmfc\DatabaseEnv;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class DatabaseEnvRepository
{
    /**
     * @return Collection
     */
    public static function all(): Collection
    {
        return Cache::remember('database-env.all', $minutes = Carbon::now()->secondsUntilEndOfDay() / 60, static function() {
            return DatabaseEnvModel::getQuery()->get();
        });
    }
}
