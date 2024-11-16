<?php
use Tabuna\Breadcrumbs\Trail;
use App\Domains\Introduction\Models\Introduction;
use App\Domains\Introduction\Http\Controllers\Backend\IntroductionController;
    /**
     * Introduction Routes
     */
    Route::group([
        'prefix' => 'introduction',
        'as' => 'introduction.'
    ], function () {
        Route::get('create', [IntroductionController::class, 'create'])
            ->name('create')
            ->middleware('permission:admin.introduction.store')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.introduction.index')
                    ->push(__('Create Introduction'), route('admin.introduction.create'));
            });

        Route::post('store', [IntroductionController::class, 'store'])
            ->name('store')
            ->middleware('permission:admin.introduction.store');

        Route::group(['prefix' => '{introduction}'], function () {
            Route::get('edit', [IntroductionController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:admin.introduction.update')
                ->breadcrumbs(function (Trail $trail, Introduction $introduction) {
                    $trail->parent('admin.introduction.index', $introduction)
                        ->push(__('Editing :entity', ['entity' => __('Introduction')]), route('admin.introduction.edit', $introduction));
                });

            Route::patch('/', [IntroductionController::class, 'update'])
                ->name('update')
                ->middleware('permission:admin.introduction.update');

            Route::delete('delete', [IntroductionController::class, 'destroy'])
                ->name('delete')
                ->middleware('permission:admin.introduction.delete');
        });

        Route::get('/', [IntroductionController::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.introduction.list|admin.introduction.store|admin.introduction.update|admin.introduction.delete')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.dashboard')
                    ->push(__('Introduction Management'), route('admin.introduction.index'));
            });

    });
    /**
     * End Introduction Routes
     */
