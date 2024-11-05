<?php

namespace App\Domains\Lookups\Services;

use App\Domains\Lookups\Models\DeliveryFee;
use App\Services\BaseService;

/**
 * Class DeliveryFeeService
 */
class DeliveryFeeService extends BaseService
{

    /**
     * @var $entityName
     */
    protected $entityName = 'DeliveryFee';

    /**
     * @param DeliveryFee $deliveryFee
     */
    public function __construct(DeliveryFee $deliveryFee)
    {
        $this->model = $deliveryFee;
    }
}
