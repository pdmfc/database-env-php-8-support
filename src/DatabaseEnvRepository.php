<?php

namespace Pdmfc\DatabaseEnv;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DatabaseEnvRepository
{
    /**
     * @return mixed
     */
    public static function all()
    {
        return Cache::remember('database-env.all', $minutes = Carbon::now()->secondsUntilEndOfDay() / 60, static function() {
            $return = new Collection();
            try {
                $return = DatabaseEnvModel::getQuery()->get();
            }catch (\Exception $e) {
                Log::info('DatabaseEnvRepository: ' . $e->getMessage());
            }
            return $return;
        });
    }
}
