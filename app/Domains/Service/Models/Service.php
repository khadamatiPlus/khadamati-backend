<?php

namespace App\Domains\Service\Models;

use App\Domains\Auth\Models\User;
use App\Domains\Lookups\Models\Area;
use App\Domains\Lookups\Models\Category;
use App\Domains\Lookups\Models\City;
use App\Domains\Lookups\Models\Country;
use App\Domains\Lookups\Models\Tag;
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
    protected $fillable = ['title','title_ar','mobile_number','price','new_price','','location','location_ar','description','description_ar','order','main_image','video','duration','category_id','sub_category_id','merchant_id','country_id','city_id','area_id', 'created_by_id', 'updated_by_id', 'is_verified', 'created_at', 'updated_at', 'deleted_at'];

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


    public function createdById(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,"created_by_id");
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'service_tag');
    }
    // Relationship to get all images associated with a service
    public function images()
    {
        return $this->hasMany(ServiceImage::class);
    }
    public function products()
    {
        return $this->hasMany(ServiceProduct::class);
    }

    // Get the main image of the service
    public function mainImage()
    {
        return $this->hasOne(ServiceImage::class)->where('is_main', true);
    }

}
