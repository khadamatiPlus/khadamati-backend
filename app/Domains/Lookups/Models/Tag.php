<?php
namespace App\Domains\Lookups\Models;
use App\Domains\Service\Models\Service;
use App\Models\BaseModel;
use App\Models\Traits\CreatedBy;
use Illuminate\Database\Eloquent\SoftDeletes;


class Tag extends BaseModel
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
    protected $fillable = ['created_by_id', 'updated_by_id', 'name', 'name_ar', 'parent_id','created_at', 'updated_at', 'deleted_at'];

    public function children()
    {
        return $this->hasMany(Tag::class, 'parent_id');
    }

    // Relationship to get the parent tag
    public function parent()
    {
        return $this->belongsTo(Tag::class, 'parent_id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_tag');
    }

}
