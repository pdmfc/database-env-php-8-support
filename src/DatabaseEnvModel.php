<?php

namespace Pdmfc\DatabaseEnv;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Env;

/**
 * App\DatabaseEnvModel
 *
 * @property int $id
 * @property string $name
 * @property string $key
 * @property string $value
 * @property string $type
 * @property int $subscribe
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|DatabaseEnvModel newModelQuery()
 * @method static Builder|DatabaseEnvModel newQuery()
 * @method static Builder|DatabaseEnvModel query()
 * @method static Builder|DatabaseEnvModel whereCreatedAt($value)
 * @method static Builder|DatabaseEnvModel whereId($value)
 * @method static Builder|DatabaseEnvModel whereName($value)
 * @method static Builder|DatabaseEnvModel whereKey($value)
 * @method static Builder|DatabaseEnvModel whereSubscribe($value)
 * @method static Builder|DatabaseEnvModel whereType($value)
 * @method static Builder|DatabaseEnvModel whereUpdatedAt($value)
 * @method static Builder|DatabaseEnvModel whereValue($value)
 * @mixin Eloquent
 */
class DatabaseEnvModel extends Model
{
    public const STRING = 'string';
    public const INTEGER = 'integer';
    public const BOOL = 'bool';

    protected $table = 'database-env';

    protected $guarded = [];
}
