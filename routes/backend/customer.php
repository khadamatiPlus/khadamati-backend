<?php
use Tabuna\Breadcrumbs\Trail;

use App\Domains\Customer\Models\Customer;
use App\Domains\Customer\Http\Controllers\Backend\CustomerController;

/**
     * customer Routes
     */
    Route::group([
        'prefix' => 'customer',
        'as' => 'customer.'
    ], function () {
        Route::get('create', [CustomerController::class, 'create'])
            ->name('create')
            ->middleware('permission:admin.customer.store')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.customer.index')
                    ->push(__('Create Customer'), route('admin.customer.create'));
            });

        Route::post('store', [CustomerController::class, 'store'])
            ->name('store')
            ->middleware('permission:admin.customer.store');

        Route::group(['prefix' => '{customer}'], function () {
            Route::get('edit', [CustomerController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:admin.customer.update')
                ->breadcrumbs(function (Trail $trail, Customer $customer) {
                    $trail->parent('admin.customer.index', $customer)
                        ->push(__('Editing :entity', ['entity' => __('Customer')]), route('admin.customer.edit', $customer));
                });
            Route::get('show', [CustomerController::class, 'show'])
                ->name('show')
                ->middleware('permission:admin.customer.show')
                ->breadcrumbs(function (Trail $trail, Customer $customer) {
                    $trail->parent('admin.customer.index', $customer)
                        ->push(__('Editing :entity', ['entity' => __('Captain')]), route('admin.customer.show', $customer));
                });
            Route::get('showCaptainWallet', [CustomerController::class, 'showCaptainWallet'])
                ->name('showCaptainWallet')
                ->middleware('permission:admin.customer.showCaptainWallet')
                ->breadcrumbs(function (Trail $trail, Customer $customer) {
                    $trail->parent('admin.customer.index', $customer)
                        ->push(__('Editing :entity', ['entity' => __('Captain')]), route('admin.customer.showCaptainWallet', $captain));
                });
            Route::patch('/', [CustomerController::class, 'update'])
                ->name('update')
                ->middleware('permission:admin.customer.update');

            Route::delete('delete', [CustomerController::class, 'destroy'])
                ->name('delete')
                ->middleware('permission:admin.customer.delete');
        });

        Route::get('/', [CustomerController::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.customer.list|admin.customer.store|admin.customer.update|admin.customer.delete')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.dashboard')
                    ->push(__('Customer Management'), route('admin.customer.index'));
            });

        Route::get('updateStatusByCustomerId', [CustomerController::class, 'UpdateStatus'])->name('updateStatusByCustomerId');
//        Route::get('getCaptain', [CaptainController::class, 'index'])->name('getCaptain');
//        Route::get('updateIsPausedStatusByCaptainId', [CaptainController::class, 'UpdateIsPausedStatus'])->name('updateIsPausedStatusByCaptainId');
//        Route::post('percentage/update', [CaptainController::class, 'updatePercentage'])->name('percentage.change');
//        Route::post('/add-amount', [CaptainController::class, 'addAmount'])->name('addAmount');

    });
    /**
     * End Captain Routes
     */
