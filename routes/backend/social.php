<?php
use Tabuna\Breadcrumbs\Trail;

use App\Domains\Social\Models\Social;
use App\Domains\Social\Http\Controllers\Backend\SocialController;

Route::group([
    'prefix' => 'social',
    'as' => 'social.'
], function (){
    Route::group(['prefix' => '{social}'], function () {
        Route::get('edit', [SocialController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:admin.social.update')
            ->breadcrumbs(function (Trail $trail, Social $social) {
                $trail->parent('admin.dashboard', $social)
                    ->push(__('Update Social Media'), route('admin.social.edit', $social));
            });

        Route::patch('/', [SocialController::class, 'update'])
            ->name('update')
            ->middleware('permission:admin.social.update');
    });
});
/**
 * End social Routes
 */
