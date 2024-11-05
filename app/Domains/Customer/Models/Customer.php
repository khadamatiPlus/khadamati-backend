<?php

namespace App\Domains\Customer\Models;

use App\Domains\Auth\Models\User;
use App\Domains\Captain\Models\Traits\Attribute\CaptainAttribute;
use App\Domains\Captain\Models\Traits\Scope\CaptainScope;
use App\Domains\Lookups\Models\VehicleType;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Domains\Captain\Models\CaptainCity;

/**
 * @property integer $id
 * @property integer $vehicle_type_id
 * @property integer $profile_id
 * @property integer $created_by_id
 * @property integer $updated_by_id
 * @property string $name
 * @property string $profile_pic
 * @property string $driving_license_card
 * @property string $car_id_card
 * @property boolean $is_verified
 * @property boolean $is_instant_delivery
 * @property boolean $status
 * @property string $latitude
 * @property string $longitude
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property VehicleType $vehicleType
 * @property User $profile
 * @property boolean $is_paused
 */
class Customer extends BaseModel
{
    use
        SoftDeletes;
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = [
        'profile_id',
        'created_by_id',
        'updated_by_id',
        'name',
        'profile_pic',
        'is_verified',
        'is_instant_delivery',
        'latitude',
        'longitude',
        'created_at',
        'updated_at',
        'deleted_at',
    ];



    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function captainCities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CaptainCity::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'profile_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdById(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

}
