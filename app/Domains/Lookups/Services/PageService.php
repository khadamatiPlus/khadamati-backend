<?php

namespace App\Domains\Lookups\Services;

use App\Domains\Lookups\Models\Page;
use App\Services\BaseService;

/**
 * Class PageService
 */
class PageService extends BaseService
{

    /**
     * @var $entityName
     */
    protected $entityName = 'Page';

    /**
     * @param Page $page
     */
    public function __construct(Page $page)
    {
        $this->model = $page;
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function bySlug($slug)
    {
        return $this->model::bySlug($slug);
    }
}
