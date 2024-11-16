<?php

namespace App\Domains\Lookups\Http\Controllers\API;

use App\Domains\Lookups\Http\Transformers\LabelTransformer;
use App\Domains\Lookups\Services\LabelService;
use App\Http\Controllers\APIBaseController;
use Illuminate\Http\Request;


class LabelApiController extends APIBaseController
{

    private $labelService;

    public function __construct(LabelService $labelService)
    {
        $this->labelService = $labelService;
    }

    public function getLabels(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            return $this->successResponse($this->labelService
                ->get()
                ->transform(function ($label){
                    return (new LabelTransformer())->transform($label);
                }));
        }
        catch (\Exception $exception){
            report($exception);
            return $this->internalServerErrorResponse($exception->getMessage());
        }
    }
}
