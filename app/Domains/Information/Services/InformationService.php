<?php

namespace App\Domains\Information\Services;
use App\Domains\Information\Models\Information;
use App\Services\BaseService;
use Illuminate\Http\Request;

/**
 * Class InformationService
 */
class InformationService extends BaseService
{

    /**
     * @var $entityName
     */
    protected $entityName = 'Information';

    /**
     * @param Information $information
     */
    public function __construct(Information $information)
    {
        $this->model = $information;
    }
}
