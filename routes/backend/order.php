<?php
use Tabuna\Breadcrumbs\Trail;
use App\Domains\Delivery\Events\Order;
use App\Domains\Delivery\Http\Controllers\Backend\OrderController;
/**
     * Order Routes
     */
    Route::group([
        'prefix' => 'order',
        'as' => 'order.'
    ], function () {
        Route::get('/', [OrderController::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.order.list')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.dashboard')
                    ->push(__('Order Management'), route('admin.order.index'));
            });
        Route::get('orderDetails/{id}',[OrderController::class,'show'])->name('orderDetails');

    });
    /**
     * End Order Routes
     */

