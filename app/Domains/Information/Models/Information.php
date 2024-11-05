<?php

namespace App\Domains\Information\Models;

use App\Models\BaseModel;
use App\Models\Traits\CreatedBy;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $created_by_id
 * @property integer $updated_by_id
 * @property string $email
 * @property string $phone_number
 * @property string $second_number
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Information extends BaseModel
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
    protected $fillable = ['created_by_id','email','phone_number','second_phone_number','updated_by_id', 'created_at', 'updated_at', 'deleted_at'];
}
