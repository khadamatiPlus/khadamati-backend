<?php
use Tabuna\Breadcrumbs\Trail;
use App\Domains\Notification\Models\Notification;
use App\Domains\Notification\Http\Controllers\Backend\NotificationController;
    /**
     * Notification Routes
     */
    Route::group([
        'prefix' => 'notification',
        'as' => 'notification.'
    ], function () {
        Route::get('create', [NotificationController::class, 'create'])
            ->name('create')
            ->middleware('permission:admin.notification.store')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.notification.index')
                    ->push(__('Create Notification'), route('admin.notification.create'));
            });

        Route::post('store', [NotificationController::class, 'store'])
            ->name('store')
            ->middleware('permission:admin.notification.store');

        Route::group(['prefix' => '{notification}'], function () {
            Route::get('edit', [NotificationController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:admin.notification.update')
                ->breadcrumbs(function (Trail $trail, Notification $notification) {
                    $trail->parent('admin.notification.index', $notification)
                        ->push(__('Editing :entity', ['entity' => __('Notification')]), route('admin.notification.edit', $notification));
                });

            Route::patch('/', [NotificationController::class, 'update'])
                ->name('update')
                ->middleware('permission:admin.notification.update');

            Route::delete('delete', [NotificationController::class, 'destroy'])
                ->name('delete')
                ->middleware('permission:admin.notification.delete');
        });

        Route::get('/', [NotificationController::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.notification.list|admin.notification.store|admin.notification.update|admin.notification.delete')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.dashboard')
                    ->push(__('Notification Management'), route('admin.notification.index'));
            });
        Route::get('sendNotification', [NotificationController::class, 'sendNotification'])->name('sendNotification');

    });
    /**
     * End Notification Routes
     */
