<?php
namespace App\Domains\Notification\Models;
use App\Models\BaseModel;
use App\Domains\Auth\Models\User;
/**
 * @property integer $id
 * @property integer $created_by_id
 * @property integer $updated_by_id
 * @property string $is_sent
 * @property string $title
 * @property string $title_ar
 * @property string $description
 * @property string $description_ar
 * @property string $notification_icon
 * @property string $type
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property User $user
 */
class Notification extends BaseModel
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
    protected $fillable = [ 'is_sent','created_by_id', 'updated_by_id', 'title', 'title_ar', 'description', 'description_ar', 'notification_icon', 'type', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
