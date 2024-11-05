<?php

namespace App\Http\Livewire\Backend;

use App\Domains\Lookups\Models\City;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use function view;


class CityTable extends DataTableComponent
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
            Column::make(__('Country'), 'country_id')
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
        return City::query()->orderByDesc('created_at');
    }
    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'backend.lookups.city.includes.row';
    }
}
