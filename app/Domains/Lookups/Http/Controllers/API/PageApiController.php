<?php

namespace App\Domains\Lookups\Http\Controllers\API;

use App\Domains\Lookups\Services\PageService;
use App\Http\Controllers\APIBaseController;
use Illuminate\Http\Request;

/**
 * Class PageApiController
 */
class PageApiController extends APIBaseController
{

    protected $pageService;

    /**
     * @param PageService $pageService
     */
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    /**
     * @OA\Get(
     * path="/api/lookups/getPageBySlug",
     * summary="Get App pages by slug key (about-us|terms-conditions|privacy-policy)",
     * description="",
     * operationId="getPageBySlug",
     * tags={"Lookups"},
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by RFC2616 <https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4>",
     *         @OA\Schema(
     *             type="string",
     *             default="en"
     *         )
     *     ),
     *      @OA\Parameter(
     *          name="slug",
     *          description="this is the page key",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              default="terms-conditions"
     *          )
     *      ),
     * @OA\Response(
     *    response=400,
     *    description="input validation errors"
     * ),
     * @OA\Response(
     *    response=500,
     *    description="internal server error"
     * ),
     *     @OA\Response(
     *    response=200,
     *    description="success"
     * )
     * )
     */
    public function getPageBySlug(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            return $this->successResponse($this->pageService->bySlug($request->slug)->get()->map(function ($page){
                return [
                    'title' => $page->title,
                    'description' => $page->description
                ];
            })->first());
        }
        catch (\Exception $exception){
            report($exception);
            return $this->internalServerErrorResponse($exception->getMessage());
        }
    }
}
