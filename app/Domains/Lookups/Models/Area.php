<?php

namespace App\Domains\Lookups\Models;

use App\Domains\Auth\Models\User;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $country_id
 * @property integer $created_by_id
 * @property integer $updated_by_id
 * @property string $name
 * @property string $name_ar
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property Country $country
 * @property User[] $users
 */
class Area extends BaseModel
{
    use SoftDeletes;
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['city_id', 'created_by_id', 'updated_by_id', 'name', 'name_ar', 'deleted_at', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }
}
