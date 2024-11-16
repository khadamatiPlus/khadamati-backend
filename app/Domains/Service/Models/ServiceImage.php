<?php

namespace App\Domains\Service\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


class ServiceImage extends BaseModel
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
    protected $fillable = ['image','service_id','is_main','created_at', 'updated_at', 'deleted_at'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

}
