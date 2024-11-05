<?php
use Tabuna\Breadcrumbs\Trail;
use App\Domains\Information\Models\Information;
use App\Domains\Information\Http\Controllers\Backend\InformationController;
/**
     * Information Routes
     */
    Route::group([
        'prefix' => 'information',
        'as' => 'information.'
    ], function () {
        Route::get('create', [InformationController::class, 'create'])
            ->name('create')
            ->middleware('permission:admin.information.store')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.information.index')
                    ->push(__('Create Information'), route('admin.information.create'));
            });

        Route::post('store', [InformationController::class, 'store'])
            ->name('store')
            ->middleware('permission:admin.information.store');

        Route::group(['prefix' => '{information}'], function () {
            Route::get('edit', [InformationController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:admin.information.update')
                ->breadcrumbs(function (Trail $trail, Information $information) {
                    $trail->parent('admin.information.index', $information)
                        ->push(__('Editing :entity', ['entity' => __('Information')]), route('admin.information.edit', $information));
                });

            Route::patch('/', [InformationController::class, 'update'])
                ->name('update')
                ->middleware('permission:admin.information.update');

            Route::delete('delete', [InformationController::class, 'destroy'])
                ->name('delete')
                ->middleware('permission:admin.information.delete');
        });

        Route::get('/', [InformationController::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.information.list|admin.information.store|admin.information.update|admin.information.delete')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.dashboard')
                    ->push(__('Information Management'), route('admin.information.index'));
            });
    });
    /**
     * End Information Routes
     */
