<?php

namespace App\Http\Livewire\Backend;

use App\Domains\Lookups\Models\DeliveryFee;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use function view;


class DeliveryFeesTable extends DataTableComponent
{
    /**
     * @return array
     */
    public function columns():array
    {
        return [
            Column::make(__('Amount'),'amount')
                ->searchable(),
            Column::make(__('Actions'))
        ];
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return DeliveryFee::query()->orderByDesc('created_at');
    }
    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'backend.lookups.delivery-fee.includes.row';
    }
}
