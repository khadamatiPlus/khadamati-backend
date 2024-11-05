<?php

namespace App\Domains\Rating\Models;

use App\Domains\Auth\Models\User;
use App\Domains\Captain\Models\Captain;
use App\Domains\Merchant\Models\Merchant;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


class Rating extends BaseModel
{

    use
        SoftDeletes;

    protected $table = 'ratings';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['merchant_id', 'captain_id', 'rate', 'notes', 'created_by_id', 'updated_by_id',  'created_at', 'updated_at', 'deleted_at'];


    // Define relationships
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function captain()
    {
        return $this->belongsTo(Captain::class);
    }
}
