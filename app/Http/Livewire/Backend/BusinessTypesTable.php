<?php

namespace App\Http\Livewire\Backend;

use App\Domains\Lookups\Models\BusinessType;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use function view;


class BusinessTypesTable extends DataTableComponent
{
    /**
     * @return array
     */
    public function columns():array
    {
        return [
            Column::make(__('Name'),'name')
                ->searchable(),
            Column::make(__('Arabic Name'),'name_ar')
                ->searchable(),
            Column::make(__('Actions'))
        ];
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return BusinessType::query()->orderByDesc('created_at');
    }
    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'backend.lookups.business-type.includes.row';
    }
}
