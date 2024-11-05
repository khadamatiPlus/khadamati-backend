<?php

namespace App\Http\Livewire\Backend;

use App\Domains\Lookups\Models\Country;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use function view;

class CountriesTable extends DataTableComponent
{

    //public bool $perPageAll = true;
//    public int $perPage = 50;

    /**
     * @return array
     */
    public function columns():array
    {
        return [
            Column::make(__('Name'),'name')
                ->searchable()
                ->sortable(),
            Column::make(__('Arabic Name'),'name_ar')
                ->searchable()
                ->sortable(),
            Column::make(__('Code'), 'code')
                ->searchable()
                ->sortable(),
            Column::make(__('Phone Code'), 'phone_code')
                ->searchable()
                ->sortable(),
            Column::make(__('Actions'))
        ];
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Country::query()->orderByDesc('created_at');
    }

    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'backend.lookups.country.includes.row';
    }
}
