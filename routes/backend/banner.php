<?php
use Tabuna\Breadcrumbs\Trail;
use App\Domains\Banner\Models\Banner;
use App\Domains\Banner\Http\Controllers\Backend\BannerController;
    /**
     * Banner Routes
     */
    Route::group([
        'prefix' => 'banner',
        'as' => 'banner.'
    ], function () {
        Route::get('create', [BannerController::class, 'create'])
            ->name('create')
            ->middleware('permission:admin.banner.store')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.banner.index')
                    ->push(__('Create Banner'), route('admin.banner.create'));
            });

        Route::post('store', [BannerController::class, 'store'])
            ->name('store')
            ->middleware('permission:admin.banner.store');

        Route::group(['prefix' => '{banner}'], function () {
            Route::get('edit', [BannerController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:admin.banner.update')
                ->breadcrumbs(function (Trail $trail, Banner $banner) {
                    $trail->parent('admin.banner.index', $banner)
                        ->push(__('Editing :entity', ['entity' => __('Banner')]), route('admin.banner.edit', $banner));
                });

            Route::patch('/', [BannerController::class, 'update'])
                ->name('update')
                ->middleware('permission:admin.banner.update');

            Route::delete('delete', [BannerController::class, 'destroy'])
                ->name('delete')
                ->middleware('permission:admin.banner.delete');
        });

        Route::get('/', [BannerController::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.banner.list|admin.banner.store|admin.banner.update|admin.banner.delete')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.dashboard')
                    ->push(__('Banner Management'), route('admin.banner.index'));
            });

    });
    /**
     * End Banner Routes
     */
