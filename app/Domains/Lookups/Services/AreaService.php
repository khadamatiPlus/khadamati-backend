<?php

namespace App\Domains\Lookups\Services;
use App\Domains\Lookups\Models\Area;
use App\Services\BaseService;

/**
 * Class CityService
 */
class AreaService extends BaseService
{

    /**
     * @var $entityName
     */
    protected $entityName = 'Area';

    /**
     * @param Area $area
     */
    public function __construct(Area $area)
    {
        $this->model = $area;
    }
}
