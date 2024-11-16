<?php
namespace App\Domains\Lookups\Models;
use App\Domains\Auth\Models\User;
use App\Domains\Product\Models\Product;
use App\Models\BaseModel;

/**
 * @property integer $id
 * @property integer $parent_id
 * @property integer $created_by_id
 * @property integer $updated_by_id
 * @property string $name
 * @property string $name_ar
 * @property string $summary
 * @property string $summary_ar
 * @property string $image
 * @property boolean $status
 * @property boolean $is_featured
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property User $user

 */
class Category extends BaseModel
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
    protected $fillable = ['created_by_id','parent_id','name','name_ar','is_featured','updated_by_id', 'summary','summary_ar','status', 'image','created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Relationship to get the parent tag
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
