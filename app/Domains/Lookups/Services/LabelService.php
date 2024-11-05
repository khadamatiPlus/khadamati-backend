<?php

namespace App\Domains\Lookups\Services;

use App\Domains\Lookups\Models\Label;
use App\Services\BaseService;

/**
 * Class VehicleTypeService
 */
class LabelService extends BaseService
{

    /**
     * @var $entityName
     */
    protected $entityName = 'Label';

    public function __construct(Label $label)
    {
        $this->model = $label;
    }
}
