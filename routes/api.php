<?php

use \App\Domains\Lookups\Http\Controllers\API\LocationApiController;
use App\Domains\Lookups\Http\Controllers\API\PageApiController;
use App\Domains\Auth\Http\Controllers\API\RegisterApiController;
use App\Domains\Auth\Http\Controllers\API\LoginApiController;
use App\Domains\Auth\Http\Controllers\API\UserManagementApiController;
use App\Domains\Lookups\Http\Controllers\API\VehicleTypeApiController;
use App\Domains\Lookups\Http\Controllers\API\BusinessTypeApiController;
use App\Http\Middleware\ForceJsonResponse;
use App\Http\Middleware\ApiLocaleMiddleware;
use App\Http\Middleware\CheckCaptainVerifiedMiddleware;
use App\Domains\Captain\Http\Controllers\API\CaptainApiController;
use App\Domains\Merchant\Http\Controllers\API\MerchantApiController;
use App\Domains\Delivery\Http\Controllers\API\OrderApiController;
use App\Http\Middleware\CheckMerchantVerifiedMiddleware;
use App\Domains\Lookups\Http\Controllers\API\UserTypeApiController;
use App\Domains\Lookups\Http\Controllers\API\DeliveryFeeApiController;
use App\Domains\Rating\Http\Controllers\API\RatingApiController;
use App\Domains\Notification\Http\Controllers\API\NotificationApiController;
use App\Domains\Information\Http\Controllers\API\InformationApiController;
use App\Domains\Social\Http\Controllers\API\SocialApiController;
use App\Domains\Delivery\Http\Controllers\API\CaptainOrdersApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//force json response middleware
Route::group(['middleware' => ForceJsonResponse::class], function (){

    //localization group middleware
    Route::group(['middleware' => ApiLocaleMiddleware::class], function (){

        Route::group([
            'prefix' => 'lookups',
            'as' => 'lookups.'
        ], function(){

            Route::get('getCountries', [LocationApiController::class, 'getCountries']);

            Route::get('getCities', [LocationApiController::class, 'getCities']);
            Route::get('getVehicleTypes', [VehicleTypeApiController::class, 'getVehicleTypes']);
            Route::get('getBusinessTypes', [BusinessTypeApiController::class, 'getBusinessTypes']);
            Route::get('getUserTypes', [UserTypeApiController::class, 'getUserTypes']);
            Route::get('getDeliveryFees', [DeliveryFeeApiController::class, 'getDeliveryFees']);
            Route::get('getInformation', [InformationApiController::class, 'getInformation']);
            Route::get('getSocial', [SocialApiController::class, 'getSocial']);

            Route::get('getPageBySlug', [PageApiController::class, 'getPageBySlug']);
        });


        //Required Auth token routes
        Route::group(['middleware' => 'authSanctum'], function (){
            Route::group([
                'prefix' => 'notifications',
                'as' => 'notifications.'
            ], function () {
                Route::get('getNotifications', [NotificationApiController::class, 'getNotifications']);
            });

            Route::group([
                'prefix' => 'delivery',
                'as' => 'delivery.'
            ], function (){

                Route::group([
                    'prefix' => 'order',
                    'as' => 'order.'
                ], function(){

                    //Merchant Order management Routes
                    Route::get('show', [OrderApiController::class, 'show']);
//                    Route::post('merchantAction', [OrderApiController::class, 'merchantAction']);
                    //End Merchant Order management Routes

                });

            });
            Route::group(['middleware' => CheckMerchantVerifiedMiddleware::class], function (){

                //delivery routes
                Route::group([
                    'prefix' => 'delivery',
                    'as' => 'delivery.'
                ], function (){

                    Route::group([
                        'prefix' => 'order',
                        'as' => 'order.'
                    ], function(){

                        //Merchant Order management Routes
                        Route::post('merchantAction', [OrderApiController::class, 'merchantAction']);
                        Route::get('orderList', [OrderApiController::class, 'list']);
                        Route::post('storeOrderAsMerchant', [OrderApiController::class, 'storeOrderAsMerchant']);
                        //End Merchant Order management Routes

                    });

                });
            });
                //end delivery routes
            Route::group(['middleware' => CheckCaptainVerifiedMiddleware::class],function(){
                Route::group([
                    'prefix' => 'captain',
                    'as' => 'captain.'
                ], function () {

                    Route::post('update', [CaptainApiController::class, 'update']);
                    Route::get('profile', [CaptainApiController::class, 'profile']);

                    //delivery routes
                    Route::group([
                        'prefix' => 'delivery',
                        'as' => 'delivery.'
                    ], function () {

                        Route::group([
                            'prefix' => 'order',
                            'as' => 'order.'
                        ], function () {

                            //Captain Order management Routes

                            Route::get('list', [CaptainOrdersApiController::class, 'list']);

                            //End Captain Order management Routes

                        });
                    });
                });
            });
                Route::group([
                    'prefix' => 'merchant',
                    'as' => 'merchant.'
                ], function (){
                    Route::group(['middleware' => CheckMerchantVerifiedMiddleware::class], function () {

                        Route::post('update', [MerchantApiController::class, 'update']);
                        Route::get('profile', [MerchantApiController::class, 'profile']);
                        Route::post('storeRating', [RatingApiController::class, 'store']);
                    });
            });



        });
        //auth process routes
        Route::group([
            'prefix' => 'auth',
            'as' => 'auth.'
        ], function (){

            Route::post('registerMerchant', [RegisterApiController::class, 'registerMerchant']);
            Route::post('authenticate', [LoginApiController::class, 'mobileAuthenticate']);
            Route::post('registerCaptain', [RegisterApiController::class,'registerCaptain']);

//            Route::get('generateOTP', [UserManagementApiController::class, 'generateOTP']);
//            Route::get('checkAuthEnabled', [UserManagementApiController::class, 'checkAuthEnabled']);
        });
        //Optional Auth token for data changes only such as (is_favorite on item returned by public api)
        Route::group(['middleware' => 'optionalAuthSanctum'],function (){

        });

    });
});