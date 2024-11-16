<?php

namespace App\Domains\Introduction\Http\Controllers\API;
use App\Domains\Introduction\Http\Transformers\IntroductionTransformer;
use App\Domains\Introduction\Services\IntroductionService;
use App\Http\Controllers\APIBaseController;
use Illuminate\Http\Request;

class IntroductionApiController extends APIBaseController
{


    private $introductionService;


    public function __construct(IntroductionService $introductionService)
    {
        $this->introductionService = $introductionService;
    }


    public function getIntroductions(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->successResponse($this->introductionService
                ->get()
                ->transform(function ($introductions) {
                    return (new IntroductionTransformer)->transform($introductions);
                }));
        } catch (\Exception $exception) {
            report($exception);
            return $this->internalServerErrorResponse($exception->getMessage());
        }
    }
}
