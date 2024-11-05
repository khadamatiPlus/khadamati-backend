<?php

namespace App\Domains\Lookups\Services;

use App\Domains\Lookups\Models\City;
use App\Services\BaseService;

/**
 * Class CityService
 */
class CityService extends BaseService
{

    /**
     * @var $entityName
     */
    protected $entityName = 'City';

    /**
     * @param City $city
     */
    public function __construct(City $city)
    {
        $this->model = $city;
    }
}
