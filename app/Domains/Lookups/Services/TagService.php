<?php

namespace App\Domains\Lookups\Services;

use App\Domains\Lookups\Models\Tag;
use App\Services\BaseService;

/**
 * Class TagService
 */
class TagService extends BaseService
{

    /**
     * @var $entityName
     */
    protected $entityName = 'Tag';

    /**
     * @param Tag $tag
     */
    public function __construct(Tag $tag)
    {
        $this->model = $tag;
    }
}
