<?php
use Tabuna\Breadcrumbs\Trail;
use App\Domains\Merchant\Models\Merchant;
use App\Domains\Merchant\Http\Controllers\Backend\MerchantController;
    /**
     * Merchant Routes
     */
    Route::group([
        'prefix' => 'merchant',
        'as' => 'merchant.'
    ], function () {
        Route::get('create', [MerchantController::class, 'create'])
            ->name('create')
            ->middleware('permission:admin.merchant.store')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.merchant.index')
                    ->push(__('Create Merchant'), route('admin.merchant.create'));
            });

        Route::post('store', [MerchantController::class, 'store'])
            ->name('store')
            ->middleware('permission:admin.merchant.store');

        Route::group(['prefix' => '{merchant}'], function () {
            Route::get('edit', [MerchantController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:admin.merchant.update')
                ->breadcrumbs(function (Trail $trail, Merchant $merchant) {
                    $trail->parent('admin.merchant.index', $merchant)
                        ->push(__('Editing :entity', ['entity' => __('Merchant')]), route('admin.merchant.edit', $merchant));
                });
            Route::get('show', [MerchantController::class, 'show'])
                ->name('show')
                ->middleware('permission:admin.merchant.show')
                ->breadcrumbs(function (Trail $trail, Merchant $merchant) {
                    $trail->parent('admin.merchant.index', $merchant)
                        ->push(__('Editing :entity', ['entity' => __('Merchant')]), route('admin.merchant.show', $merchant));
                });
            Route::get('showMerchantNotification', [MerchantController::class, 'showMerchantNotification'])
                ->name('showMerchantNotification')
                ->middleware('permission:admin.merchant.showMerchantNotification')
                ->breadcrumbs(function (Trail $trail, Merchant $merchant) {
                    $trail->parent('admin.merchant.index', $merchant)
                        ->push(__('Editing :entity', ['entity' => __('Merchant')]), route('admin.merchant.showMerchantNotification', $merchant));
                });
            Route::patch('/', [MerchantController::class, 'update'])
                ->name('update')
                ->middleware('permission:admin.merchant.update');

            Route::delete('delete', [MerchantController::class, 'destroy'])
                ->name('delete')
                ->middleware('permission:admin.merchant.delete');
        });

        Route::get('/', [MerchantController::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.merchant.list|admin.merchant.store|admin.merchant.update|admin.merchant.delete')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.dashboard')
                    ->push(__('Merchant Management'), route('admin.merchant.index'));
            });
        Route::get('updateStatusByMerchantId', [MerchantController::class, 'updateStatus'])->name('updateStatusByMerchantId');
    });
    /**
     * End Merchant Routes
     */

