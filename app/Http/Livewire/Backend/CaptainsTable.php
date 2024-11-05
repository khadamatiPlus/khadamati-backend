<?php

namespace App\Http\Livewire\Backend;

use App\Domains\Captain\Models\Captain;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Filter;
use App\Domains\Lookups\Models\VehicleType;
use function view;


class CaptainsTable extends DataTableComponent
{
    /**
     * @return array
     */
    public function columns():array
    {
        return [
            Column::make(__('Name'),'name')
                ->searchable(),
            Column::make(__('Mobile Number')),
            Column::make(__('Vehicle Type')),
            Column::make(__('Is Verified'),'is_verified'),
            Column::make(__('Is Paused'),'is_paused'),
            Column::make(__('App Percentage'),'percentage'),
            Column::make(__('Actions'))
        ];
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        $query = Captain::query()
            ->when($this->getFilter('isVerifiedFilter'), fn ($query, $isVerifiedFilter) => $isVerifiedFilter === 'true' ? $query->where('is_verified', 1) : $query->where('is_verified', 0))
            ->when($this->getFilter('isInstantDelivery'), fn ($query, $isInstantFilter) => $isInstantFilter === 'true' ? $query->where('is_instant_delivery', 1) : $query->where('is_instant_delivery', 0))
            ->when($this->getFilter('vehicle_type_id'), fn ($query, $vehicle_type_id) => $query->where('vehicle_type_id', $vehicle_type_id))
            ->orderByDesc('created_at');
        return $query;


    }

    public function filters(): array
    {
        return [
            'isVerifiedFilter' => Filter::make('Is Verified')
                ->select([
                    '' => __('All'),
                    'true' => __('Verified'),
                    'false' => __('Unverified'),
                ]),
            'isInstantDelivery' => Filter::make('Is Internal Employee')
                ->select([
                    '' => __('All'),
                    'true' => __('Instant Delivery'),
                    'false' => __('Not Instant Delivery'),
                ]),
               'vehicle_type_id' => Filter::make(__('Vehicle Type'))
                ->select(VehicleType::query()
                    ->select(['id','name'])
                    ->get()
                    ->prepend((object)[
                        'id' => '',
                        'name' => __('All')
                    ])
                    ->pluck('name','id')->toArray()),
        ];
    }

    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'backend.captain.includes.row';
    }
}
