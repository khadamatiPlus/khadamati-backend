<?php

namespace App\Domains\Merchant\Models;

use App\Domains\Auth\Models\User;
//use App\Domains\Delivery\Models\Order;
use App\Domains\Lookups\Models\BusinessType;
use App\Domains\Lookups\Models\City;
use App\Domains\Merchant\Http\Transformers\MerchantTransformer;
use App\Domains\Merchant\Models\Traits\Scope\MerchantScope;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @property integer $id
 * @property integer $city_id
 * @property integer $business_type_id
 * @property integer $created_by_id
 * @property integer $updated_by_id
 * @property string $name
 * @property string $profile_pic
 * @property string $latitude
 * @property string $longitude
 * @property boolean $is_verified
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $profile_id
 * @property City $city
 * @property User[] $users
 * @property User $profile
 */
class Merchant extends BaseModel
{

    use MerchantScope,
        SoftDeletes;

    protected $table = 'merchants';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['city_id', 'created_by_id', 'updated_by_id', 'name','latitude','business_type_id','longitude' ,'profile_pic', 'is_verified', 'created_at', 'updated_at', 'deleted_at','profile_id'];

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
//    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
//    {
//        return $this->hasMany(Order::class);
//    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function createdById(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,"created_by_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'profile_id');
    }
}
