<?php

namespace App\Domains\Lookups\Http\Controllers\API;

use App\Domains\Lookups\Http\Transformers\DeliveryFeeTransformer;
use App\Domains\Lookups\Http\Transformers\TagTransformer;
use App\Domains\Lookups\Services\DeliveryFeeService;
use App\Domains\Lookups\Services\TagService;
use App\Http\Controllers\APIBaseController;
use Illuminate\Http\Request;

class TagApiController extends APIBaseController
{


    private $tagService;

    /**
     * @param DeliveryFeeService $deliveryFeeService
     */
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function getTags(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Retrieve parent_id from the request, if it's provided
            $parentId = $request->input('parent_id');

            // Start building the query for tags
            $query = $this->tagService;

            // If parent_id is provided, filter by it
            if ($parentId) {
                $query->where('parent_id', $parentId);
            }

            // Paginate the query with filtering and return the transformed results
            return $this->successResponse(
                $query->paginate(10, ['*'], 'page', $request->input('page') ?? 1)
                    ->getCollection()
                    ->transform(function ($tag) {
                        return (new TagTransformer())->transform($tag);
                    })
            );
        } catch (\Exception $exception) {
            report($exception);
            return $this->internalServerErrorResponse($exception->getMessage());
        }
    }

}
