<?php

namespace App\Domains\Service\Services;
use App\Domains\Service\Models\ServiceTag;
use App\Services\BaseService;


class ServiceTagService extends BaseService
{

    /**
     * @var string $entityName
     */
    protected $entityName = 'ProductSize';


    public function __construct(ServiceTag $serviceTag)
    {
        $this->model = $serviceTag;
    }
}
