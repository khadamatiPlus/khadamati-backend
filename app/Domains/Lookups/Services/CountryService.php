<?php

namespace App\Domains\Lookups\Services;

use App\Domains\Lookups\Models\Country;
use App\Services\BaseService;

/**
 * Class CountryService
 */
class CountryService extends BaseService
{

    /**
     * @var $entityName
     */
    protected $entityName = 'Country';

    /**
     * @param Country $country
     */
    public function __construct(Country $country)
    {
        $this->model = $country;
    }
}
