<?php
use Tabuna\Breadcrumbs\Trail;
use App\Domains\Service\Models\Service;
use App\Domains\Service\Http\Controllers\Backend\ServiceController;
    /**
     * Service Routes
     */
    Route::group([
        'prefix' => 'service',
        'as' => 'service.'
    ], function () {
        Route::get('create', [ServiceController::class, 'create'])
            ->name('create')
            ->middleware('permission:admin.service.store')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.service.index')
                    ->push(__('Create Service'), route('admin.service.create'));
            });

        Route::post('store', [ServiceController::class, 'store'])
            ->name('store')
            ->middleware('permission:admin.service.store');

        Route::group(['prefix' => '{service}'], function () {
            Route::get('edit', [ServiceController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:admin.service.update')
                ->breadcrumbs(function (Trail $trail, Service $service) {
                    $trail->parent('admin.service.index', $service)
                        ->push(__('Editing :entity', ['entity' => __('Service')]), route('admin.service.edit', $service));
                });

            Route::patch('/', [ServiceController::class, 'update'])
                ->name('update')
                ->middleware('permission:admin.service.update');

            Route::delete('delete', [ServiceController::class, 'destroy'])
                ->name('delete')
                ->middleware('permission:admin.service.delete');
        });

        Route::get('/', [ServiceController::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.service.list|admin.service.store|admin.service.update|admin.service.delete')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.dashboard')
                    ->push(__('Service Management'), route('admin.service.index'));
            });

    });
    /**
     * End Service Routes
     */
