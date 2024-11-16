<?php

namespace App\Domains\Service\Models;

use App\Domains\Lookups\Models\Tag;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


class ServiceProduct extends BaseModel
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
    protected $fillable = ['service_id','title','description','price','duration','image','created_by_id', 'updated_by_id','created_at', 'updated_at', 'deleted_at'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

}
