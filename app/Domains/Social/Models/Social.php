<?php

namespace App\Domains\Social\Models;

use App\Models\BaseModel;
use App\Models\Traits\CreatedBy;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $created_by_id
 * @property integer $updated_by_id
 * @property string $x
 * @property string $whatsapp
 * @property string $tiktok
 * @property string $youtube
 * @property string $facebook
 * @property string $instagram
 * @property string $snapchat
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Social extends BaseModel
{
    use SoftDeletes,CreatedBy;
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['created_by_id','x','snapchat','whatsapp','tiktok','youtube','instagram','facebook','updated_by_id', 'created_at', 'updated_at', 'deleted_at'];
}
