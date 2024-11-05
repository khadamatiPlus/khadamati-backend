<?php

namespace App\Domains\Service\Models;

use App\Domains\Auth\Models\User;
use App\Domains\Lookups\Models\Area;
use App\Domains\Lookups\Models\Category;
use App\Domains\Lookups\Models\City;
use App\Domains\Lookups\Models\Country;
use App\Domains\Merchant\Models\Merchant;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


class Service extends BaseModel
{

    use SoftDeletes;

    protected $table = 'services';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['title','title_ar','mobile_number','price','location','location_ar','description','description_ar','order','main_image','video','duration','category_id','sub_category_id','merchant_id','country_id','city_id','area_id', 'created_by_id', 'updated_by_id', 'name','latitude','business_type_id','longitude' ,'profile_pic', 'is_verified', 'created_at', 'updated_at', 'deleted_at','profile_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Area::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function merchant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class,'sub_category_id');
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
