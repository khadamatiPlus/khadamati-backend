<?php

namespace App\Http\Controllers;

use App\Enums\Core\ErrorTypes;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(title="API Swagger documentation", version="1.0.0")
 * @OA\Schemes(format="http")
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      in="header",
 *      name="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 * ),
 *
 */
class APIBaseController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 200 Success Request
     * @param $data
     * @param array $responseHeaders
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data, string $message = 'Request successful', array $responseHeaders = []): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], 200, $responseHeaders, JSON_UNESCAPED_SLASHES);
    }


    /**
     * 400 Bad Request – This means that client-side input fails validation.
     * @param $data
     * @param array $responseHeaders
     * @return \Illuminate\Http\JsonResponse
     */
    protected function inputValidationErrorResponse($error, array $responseHeaders = []): \Illuminate\Http\JsonResponse
    {
        return response()->json(['error_type' => ErrorTypes::GENERAL, 'errors' => [array('key' => 'general', 'error' => $error)]], 400, $responseHeaders, JSON_UNESCAPED_SLASHES);
    }

    /**
     * 403 Forbidden – This means the user is authenticated, but it’s not allowed to access a resource.
     * @param $data
     * @param array $responseHeaders
     * @return \Illuminate\Http\JsonResponse
     */
    protected function forbiddenErrorResponse($error, array $responseHeaders = []): \Illuminate\Http\JsonResponse
    {
        return response()->json(['error_type' => ErrorTypes::GENERAL, 'errors' => [array('key' => 'general', 'error' => $error)]], 403, $responseHeaders, JSON_UNESCAPED_SLASHES);
    }

    /**
     * 500 Internal server error – This is a generic server error. It probably shouldn’t be thrown explicitly.
     * @param $data
     * @param array $responseHeaders
     * @return \Illuminate\Http\JsonResponse
     */
    protected function internalServerErrorResponse($error, array $responseHeaders = []): \Illuminate\Http\JsonResponse
    {
        return response()->json(['error_type' => ErrorTypes::GENERAL, 'errors' => [array('key' => 'general', 'error' => $error)]], 500, $responseHeaders, JSON_UNESCAPED_SLASHES);
    }
}
