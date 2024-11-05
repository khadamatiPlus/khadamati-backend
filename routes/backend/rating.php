<?php
use Tabuna\Breadcrumbs\Trail;
use App\Domains\Rating\Http\Controllers\Backend\RatingController;
/**
     * Rating Routes
     */
    Route::group([
        'prefix' => 'rating',
        'as' => 'rating.'
    ], function () {
        Route::get('/', [RatingController::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.rating.list')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.dashboard')
                    ->push(__('Rating Management'), route('admin.rating.index'));
            });
    });
    /**
     * End Rating Routes
     */

