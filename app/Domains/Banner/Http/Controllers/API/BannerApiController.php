<?php

namespace App\Domains\Banner\Http\Controllers\API;
use App\Domains\Banner\Http\Transformers\BannerTransformer;
use App\Domains\Banner\Services\BannerService;
use App\Http\Controllers\APIBaseController;
use Illuminate\Http\Request;

class BannerApiController extends APIBaseController
{


    private $bannerService;


    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }


    public function getBanners(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->successResponse($this->bannerService
                ->get()
                ->transform(function ($notifications) {
                    return (new BannerTransformer)->transform($notifications);
                }));
        } catch (\Exception $exception) {
            report($exception);
            return $this->internalServerErrorResponse($exception->getMessage());
        }
    }
}
