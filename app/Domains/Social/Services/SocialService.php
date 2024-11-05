<?php

namespace App\Domains\Social\Services;
use App\Domains\Social\Models\Social;
use App\Services\BaseService;
use Illuminate\Http\Request;

/**
 * Class SocialService
 */
class SocialService extends BaseService
{

    /**
     * @var $entityName
     */
    protected $entityName = 'Social';
    /**
     * @param Social $social
     */
    public function __construct(Social $social)
    {
        $this->model = $social;
    }
}
