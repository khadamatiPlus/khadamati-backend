<?php
namespace App\Domains\Introduction\Models;
use App\Models\BaseModel;
use App\Domains\Auth\Models\User;

class Introduction extends BaseModel
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = [ 'status','created_by_id', 'updated_by_id', 'title', 'title_ar' , 'image','description','description_ar','created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
