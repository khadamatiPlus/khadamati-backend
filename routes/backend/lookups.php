<?php
use Tabuna\Breadcrumbs\Trail;
use App\Domains\Lookups\Models\Country;
use App\Domains\Lookups\Models\City;
use App\Domains\Lookups\Models\Area;
use App\Domains\Lookups\Http\Controllers\Backend\CountryController;
use App\Domains\Lookups\Http\Controllers\Backend\CityController;
use App\Domains\Lookups\Http\Controllers\Backend\AreaController;
use App\Domains\Lookups\Models\Page;
use App\Domains\Lookups\Http\Controllers\Backend\PageController;
use App\Domains\Lookups\Models\Tag;
use App\Domains\Lookups\Http\Controllers\Backend\TagController;
use App\Domains\Lookups\Models\Label;
use App\Domains\Lookups\Http\Controllers\Backend\LabelController;
use App\Domains\Lookups\Models\UserType;
use App\Domains\Lookups\Http\Controllers\Backend\UserTypeController;
use App\Domains\Lookups\Http\Controllers\Backend\CategoryController;
use App\Domains\Lookups\Models\Category;

Route::group([
    'prefix' => 'lookups',
    'as' => 'lookups.',
    'middleware' => config('boilerplate.access.middleware.verified'),
], function (){

    /**
     * Countries Routes
     */
    Route::group([
        'prefix' => 'country',
        'as' => 'country.'
    ], function (){
        Route::get('create', [CountryController::class, 'create'])
            ->name('create')
            ->middleware('permission:admin.lookups.country.store')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.lookups.country.index')
                    ->push(__('Create Country'), route('admin.lookups.country.create'));
            });

        Route::post('store', [CountryController::class, 'store'])
            ->name('store')
            ->middleware('permission:admin.lookups.country.store');

        Route::group(['prefix' => '{country}'], function () {
            Route::get('edit', [CountryController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:admin.lookups.country.update')
                ->breadcrumbs(function (Trail $trail, Country $country) {
                    $trail->parent('admin.lookups.country.index', $country)
                        ->push(__('Editing :entity', ['entity' => __('Country')]), route('admin.lookups.country.edit', $country));
                });

            Route::patch('/', [CountryController::class, 'update'])
                ->name('update')
                ->middleware('permission:admin.lookups.country.update');

            Route::delete('delete', [CountryController::class, 'destroy'])
                ->name('delete')
                ->middleware('permission:admin.lookups.country.delete');
        });

        Route::get('/', [CountryController::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.lookups.country.list|admin.lookups.country.store|admin.lookups.country.update|admin.lookups.country.delete')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.dashboard')
                    ->push(__('Country Management'), route('admin.lookups.country.index'));
            });
    });
    /**
     * End Countries Routes
     */

    /**
     * City Routes
     */
    Route::group([
        'prefix' => 'city',
        'as' => 'city.'
    ], function (){
        Route::get('/', [CityController::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.lookups.city.list|admin.lookups.city.store|admin.lookups.city.update|admin.lookups.city.delete')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.dashboard')
                    ->push(__('City Management'), route('admin.lookups.city.index'));
            });

        Route::get('create', [CityController::class, 'create'])
            ->name('create')
            ->middleware('permission:admin.lookups.city.store')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.lookups.city.index')
                    ->push(__('Create City'), route('admin.lookups.city.create'));
            });

        Route::post('store', [CityController::class, 'store'])
            ->name('store')
            ->middleware('permission:admin.lookups.city.store');

        Route::group(['prefix' => '{city}'], function () {
            Route::get('edit', [CityController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:admin.lookups.city.update')
                ->breadcrumbs(function (Trail $trail, City $city) {
                    $trail->parent('admin.lookups.city.index', $city)
                        ->push(__('Editing :entity', ['entity' => __('City')]), route('admin.lookups.city.edit', $city));
                });

            Route::patch('/', [CityController::class, 'update'])
                ->name('update')
                ->middleware('permission:admin.lookups.city.update');

            Route::delete('delete', [CityController::class, 'destroy'])
                ->name('delete')
                ->middleware('permission:admin.lookups.city.delete');
        });

        //get cities by country route
        Route::get('getCitiesByCountryId', [CityController::class, 'getByCountryId'])->name('getCitiesByCountryId');
    });
    /**
     * End City Routes
     */


    /**
     * Area Routes
     */
    Route::group([
        'prefix' => 'area',
        'as' => 'area.'
    ], function (){
        Route::get('/', [AreaController::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.lookups.area.list|admin.lookups.area.store|admin.lookups.area.update|admin.lookups.area.delete')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.dashboard')
                    ->push(__('Area Management'), route('admin.lookups.area.index'));
            });

        Route::get('create', [AreaController::class, 'create'])
            ->name('create')
            ->middleware('permission:admin.lookups.area.store')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.lookups.area.index')
                    ->push(__('Create Area'), route('admin.lookups.area.create'));
            });

        Route::post('store', [AreaController::class, 'store'])
            ->name('store')
            ->middleware('permission:admin.lookups.area.store');

        Route::group(['prefix' => '{area}'], function () {
            Route::get('edit', [AreaController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:admin.lookups.area.update')
                ->breadcrumbs(function (Trail $trail, Area $area) {
                    $trail->parent('admin.lookups.area.index', $area)
                        ->push(__('Editing :entity', ['entity' => __('Area')]), route('admin.lookups.area.edit', $area));
                });

            Route::patch('/', [AreaController::class, 'update'])
                ->name('update')
                ->middleware('permission:admin.lookups.area.update');

            Route::delete('delete', [AreaController::class, 'destroy'])
                ->name('delete')
                ->middleware('permission:admin.lookups.area.delete');
        });
        //get areas by city route
        Route::get('getAreasByCityId', [AreaController::class, 'getByCityId'])->name('getAreasByCityId');
    });
    /**
     * End Area Routes
     */

    /**
     * Page Routes
     */
    Route::group([
        'prefix' => 'page',
        'as' => 'page.'
    ], function (){
        Route::get('/', [PageController::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.lookups.page.list|admin.lookups.page.store|admin.lookups.page.update|admin.lookups.page.delete')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.dashboard')
                    ->push(__('Page Management'), route('admin.lookups.page.index'));
            });

        Route::get('create', [PageController::class, 'create'])
            ->name('create')
            ->middleware('permission:admin.lookups.page.store')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.lookups.page.index')
                    ->push(__('Create Page'), route('admin.lookups.page.create'));
            });

        Route::post('store', [PageController::class, 'store'])
            ->name('store')
            ->middleware('permission:admin.lookups.page.store');

        Route::group(['prefix' => '{page}'], function () {
            Route::get('edit', [PageController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:admin.lookups.page.update')
                ->breadcrumbs(function (Trail $trail, Page $page) {
                    $trail->parent('admin.lookups.page.index', $page)
                        ->push(__('Editing :entity', ['entity' => __('Page')]), route('admin.lookups.page.edit', $page));
                });

            Route::patch('/', [PageController::class, 'update'])
                ->name('update')
                ->middleware('permission:admin.lookups.Page.update');

            Route::delete('delete', [PageController::class, 'destroy'])
                ->name('delete')
                ->middleware('permission:admin.lookups.Page.delete');
        });
    });
    /**
     * End Page Routes
     */

    /**
     * Tag Routes
     */
    Route::group([
        'prefix' => 'tag',
        'as' => 'tag.'
    ], function (){
        Route::get('/', [TagController::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.lookups.tag.list|admin.lookups.tag.store|admin.lookups.tag.update|admin.lookups.tag.delete')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.dashboard')
                    ->push(__('Tag Management'), route('admin.lookups.tag.index'));
            });

        Route::get('create', [TagController::class, 'create'])
            ->name('create')
            ->middleware('permission:admin.lookups.tag.store')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.lookups.tag.index')
                    ->push(__('Create Tag'), route('admin.lookups.tag.create'));
            });

        Route::post('store', [TagController::class, 'store'])
            ->name('store')
            ->middleware('permission:admin.lookups.tag.store');

        Route::group(['prefix' => '{tag}'], function () {
            Route::get('edit', [TagController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:admin.lookups.tag.update')
                ->breadcrumbs(function (Trail $trail, Tag $tag) {
                    $trail->parent('admin.lookups.tag.index', $tag)
                        ->push(__('Editing :entity', ['entity' => __('Tag')]), route('admin.lookups.tag.edit', $tag));
                });

            Route::patch('/', [TagController::class, 'update'])
                ->name('update')
                ->middleware('permission:admin.lookups.tag.update');

            Route::delete('delete', [TagController::class, 'destroy'])
                ->name('delete')
                ->middleware('permission:admin.lookups.tag.delete');
        });
    });
    /**
     * End Tag Routes
     */

    /**
     * label Routes
     */
    Route::group([
        'prefix' => 'label',
        'as' => 'label.'
    ], function (){
        Route::get('/', [LabelController::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.lookups.label.list|admin.lookups.label.store|admin.lookups.label.update|admin.lookups.label.delete')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.dashboard')
                    ->push(__('Label Management'), route('admin.lookups.label.index'));
            });

        Route::get('create', [LabelController::class, 'create'])
            ->name('create')
            ->middleware('permission:admin.lookups.label.store')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.lookups.label.index')
                    ->push(__('Create Label'), route('admin.lookups.label.create'));
            });

        Route::post('store', [LabelController::class, 'store'])
            ->name('store')
            ->middleware('permission:admin.lookups.label.store');

        Route::group(['prefix' => '{label}'], function () {
            Route::get('edit', [LabelController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:admin.lookups.label.update')
                ->breadcrumbs(function (Trail $trail, Label $label) {
                    $trail->parent('admin.lookups.label.index', $label)
                        ->push(__('Editing :entity', ['entity' => __('Label')]), route('admin.lookups.label.edit', $label));
                });

            Route::patch('/', [LabelController::class, 'update'])
                ->name('update')
                ->middleware('permission:admin.lookups.label.update');

            Route::delete('delete', [LabelController::class, 'destroy'])
                ->name('delete')
                ->middleware('permission:admin.lookups.label.delete');
        });
    });
    /**
     * End label Routes
     */


    /**
     * UserType Routes
     */
    Route::group([
        'prefix' => 'userType',
        'as' => 'userType.'
    ], function (){
        Route::get('/', [UserTypeController::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.lookups.userType.list|admin.lookups.userType.store|admin.lookups.userType.update|admin.lookups.userType.delete')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.dashboard')
                    ->push(__('User Type Management'), route('admin.lookups.userType.index'));
            });

        Route::get('create', [UserTypeController::class, 'create'])
            ->name('create')
            ->middleware('permission:admin.lookups.userType.store')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.lookups.userType.index')
                    ->push(__('Create User Type'), route('admin.lookups.userType.create'));
            });

        Route::post('store', [UserTypeController::class, 'store'])
            ->name('store')
            ->middleware('permission:admin.lookups.userType.store');

        Route::group(['prefix' => '{userType}'], function () {
            Route::get('edit', [UserTypeController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:admin.lookups.userType.update')
                ->breadcrumbs(function (Trail $trail, UserType $userType) {
                    $trail->parent('admin.lookups.userType.index', $userType)
                        ->push(__('Editing :entity', ['entity' => __('UserType')]), route('admin.lookups.userType.edit', $userType));
                });

            Route::patch('/', [UserTypeController::class, 'update'])
                ->name('update')
                ->middleware('permission:admin.lookups.userType.update');

            Route::delete('delete', [UserTypeController::class, 'destroy'])
                ->name('delete')
                ->middleware('permission:admin.lookups.userType.delete');
        });
    });
    /**
     * End UserType Routes
     */


    /**
     * Category Routes
     */
    Route::group([
        'prefix' => 'category',
        'as' => 'category.'
    ], function () {
        Route::get('create', [CategoryController::class, 'create'])
            ->name('create')
            ->middleware('permission:admin.lookups.category.store')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.lookups.category.index')
                    ->push(__('Create Category'), route('admin.lookups.category.create'));
            });

        Route::post('store', [CategoryController::class, 'store'])
            ->name('store')
            ->middleware('permission:admin.lookups.category.store');

        Route::group(['prefix' => '{category}'], function () {
            Route::get('edit', [CategoryController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:admin.lookups.category.update')
                ->breadcrumbs(function (Trail $trail, Category $category) {
                    $trail->parent('admin.lookups.category.index', $category)
                        ->push(__('Editing :entity', ['entity' => __('Category')]), route('admin.lookups.category.edit', $category));
                });

            Route::patch('/', [CategoryController::class, 'update'])
                ->name('update')
                ->middleware('permission:admin.lookups.category.update');

            Route::delete('delete', [CategoryController::class, 'destroy'])
                ->name('delete')
                ->middleware('permission:admin.lookups.category.delete');
        });
        Route::group(['prefix' => '{category}'], function () {
            Route::get('editTranslation', [CategoryController::class, 'editTranslation'])
                ->name('editTranslation')
                ->middleware('permission:admin.lookups.category.update')
                ->breadcrumbs(function (Trail $trail, Category $category) {
                    $trail->parent('admin.lookups.category.index', $category)
                        ->push(__('Editing :entity', ['entity' => __('Category')]), route('admin.lookups.category.editTranslation', $category));

                });
            Route::patch('/updateTranslation', [CategoryController::class, 'updateTranslation'])
                ->name('updateTranslation')
                ->middleware('permission:admin.lookups.category.update');
        });
        Route::get('/', [CategoryController::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.lookups.category.list|admin.lookups.category.store|admin.lookups.category.update|admin.lookups.category.delete')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.dashboard')
                    ->push(__('Categories Management'), route('admin.lookups.category.index'));
            });});
    /**
     * End Category Routes
     */
});
