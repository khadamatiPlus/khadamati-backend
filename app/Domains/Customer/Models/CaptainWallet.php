<?php

namespace App\Domains\Captain\Models;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $captain_id
 * @property float $available_balance
 * @property integer $created_by_id
 * @property integer $updated_by_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Captain $captain
 */
class CaptainWallet extends BaseModel
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
    protected $fillable = ['captain_id', 'available_balance', 'created_by_id', 'updated_by_id', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function captain(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Captain::class);
    }
    public function captainWalletTransactions(){
        return $this->hasMany(CaptainWalletTransaction::class);
    }

}
