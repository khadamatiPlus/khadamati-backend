<?php
use Tabuna\Breadcrumbs\Trail;
use App\Domains\EmailEngine\Http\Controllers\Backend\MailTemplateController;
use App\Domains\EmailEngine\Http\Controllers\Backend\CustomEmailController;
use Spatie\MailTemplates\Models\MailTemplate;

Route::group([
    'prefix' => 'emailEngine',
    'as' => 'emailEngine.',
    'middleware' => config('boilerplate.access.middleware.verified'),
], function () {

    /**
     * Mail Templates Routes
     */
    Route::group([
        'prefix' => 'mailTemplate',
        'as' => 'mailTemplate.'
    ], function () {

        Route::group(['prefix' => '{mailTemplate}'], function () {
            Route::get('edit', [MailTemplateController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:admin.emailEngine.mailTemplate.update')
                ->breadcrumbs(function (Trail $trail, MailTemplate $mailTemplate) {
                    $trail->parent('admin.emailEngine.mailTemplate.index', $mailTemplate)
                        ->push(__('Editing :entity', ['entity' => __('Mail Template')]), route('admin.emailEngine.mailTemplate.edit', $mailTemplate));
                });

            Route::patch('/', [MailTemplateController::class, 'update'])
                ->name('update')
                ->middleware('permission:admin.emailEngine.mailTemplate.update');
        });

        Route::get('/', [MailTemplateController::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.emailEngine.mailTemplate.list|admin.emailEngine.mailTemplate.store|admin.emailEngine.mailTemplate.update|admin.emailEngine.mailTemplate.delete')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.dashboard')
                    ->push(__('Email Template Management'), route('admin.emailEngine.mailTemplate.index'));
            });

    });
    /**
     * Ends Mail Templates Routes
     */

    /**
     * Sender Routes
     */
    Route::group([
        'prefix' => 'sender',
        'as' => 'sender.'
    ], function (){

        Route::get('toSiteAdmins', [CustomEmailController::class, 'toSiteAdmins'])
            ->name('sendToSiteAdmins')
            ->middleware('permission:admin.emailEngine.sender.toSiteAdmins')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.emailEngine.mailTemplate.index')
                    ->push(__('Send to Site Admins'), route('admin.emailEngine.sender.sendToSiteAdmins'));
            });

        Route::post('doSendToSiteAdmins', [CustomEmailController::class, 'doSendToSiteAdmins'])
            ->name('doSendToSiteAdmins')
            ->middleware('permission:admin.emailEngine.sender.toSiteAdmins');
    });
    /**
     * End Sender Routes
     */

});
?>
