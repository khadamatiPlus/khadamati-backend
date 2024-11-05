<?php

namespace App\Http\Livewire\Backend;

use App\Domains\Captain\Models\Captain;
use App\Domains\Merchant\Models\Merchant;
use App\Domains\Rating\Models\Rating;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Filter;
use App\Domains\Lookups\Models\VehicleType;
use function view;


class RatingsTable extends DataTableComponent
{
    /**
     * @return array
     */
    public function columns():array
    {
        return [
            Column::make(__('Captain Name')),
            Column::make(__('Merchant Name')),
            Column::make(__('Rate'),'rate')->footer(function($rows) {
                $totalRate = $rows->sum('rate');
                $rowCount = $rows->count();

                if ($rowCount > 0) {
                    $averageRate = $totalRate / $rowCount;
                    return   'Avg: ' . round($averageRate, 2);
                } else {
                    return 'Avg: 0';
                }
            }),

            Column::make(__('Notes'),'notes'),
            Column::make(__('Date'),'created_at'),

        ];
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        $query = Rating::query()->has('merchant')
            ->when($this->getFilter('merchantFilter'), fn ($query, $merchantFilter) => $query->where('merchant_id', $merchantFilter))
            ->when($this->getFilter('captainFilter'), fn ($query, $captainFilter) => $query->where('captain_id', $captainFilter))
            ->when($this->getFilter('fromDate'), fn($query, $fromDate) => $query->where('created_at','>=',$fromDate))
            ->when($this->getFilter('toDate'), fn($query, $toDate) => $query->where('created_at','<=',$toDate))
            ->orderByDesc('created_at');
        // Apply 'Order Status' filter
        $orderStatusFilter = $this->getFilter('orderStatusFilter');
        if ($orderStatusFilter !== null && $orderStatusFilter !== '') {
            $query->where('status', $orderStatusFilter);
        }
        return $query;


    }

    public function filters(): array
    {
        return [
            'merchantFilter' => Filter::make(__('Merchant'))
                ->select(Merchant::query()
                    ->select(['id', 'name'])
                    ->get()
                    ->prepend((object)[
                        'id' => '',
                        'name' => __('All')
                    ])
                    ->pluck('name', 'id')->toArray()),


            'captainFilter' => Filter::make(__('Captain'))
                ->select(Captain::query()
                    ->select(['profile_id', 'name'])
                    ->get()
                    ->prepend((object)[
                        'profile_id' => '',
                        'name' => __('All')
                    ])
                    ->pluck('name', 'profile_id')->toArray()),


            'fromDate' => Filter::make('From Date')
                ->date([
                    'max' => now()->format('Y-m-d')
                ]),
            'toDate' => Filter::make('To Date')
                ->date([
                    'min' => isset($this->filters['fromDate']) && $this->filters['fromDate'] ? $this->filters['fromDate']:'',
                    'max' => now()->format('Y-m-d')
                ])
        ];
    }

    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'backend.rating.includes.row';
    }
}
