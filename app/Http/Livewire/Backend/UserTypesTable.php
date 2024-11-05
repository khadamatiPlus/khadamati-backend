<?php

namespace App\Http\Livewire\Backend;

use App\Domains\Lookups\Models\UserType;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use function view;


class UserTypesTable extends DataTableComponent
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
            Column::make(__('Image'),'image'),
            Column::make(__('Actions'))
        ];
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return UserType::query()->orderByDesc('created_at');
    }
    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'backend.lookups.user-type.includes.row';
    }
}
