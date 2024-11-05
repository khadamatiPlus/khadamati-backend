<?php

namespace App\Http\Livewire\Backend;

use App\Domains\Captain\Models\Captain;
use App\Domains\Delivery\Models\Order;
use App\Domains\Merchant\Models\Merchant;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Filter;
use App\Domains\Lookups\Models\VehicleType;
use function view;


class OrdersTable extends DataTableComponent
{
    /**
     * @return array
     */
    public function columns():array
    {
        return [
            Column::make(__('Order Reference')),
            Column::make(__('Merchant Name')),
            Column::make(__('Order Amount'),'order_amount'),
            Column::make(__('Delivery Amount'),'delivery_amount'),
            Column::make(__('Customer Phone Number')),
            Column::make(__('Order Status'),'status'),
            Column::make(__('Order Location')),
            Column::make(__('Actions'))
        ];
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        $query = Order::query()->has('merchant')
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
                        'first_name' => __('All')
                    ])
                    ->pluck('first_name', 'profile_id')->toArray()),

            'orderStatusFilter' => Filter::make('Order Status')
                ->select([
                    '' => __('All'),
                    '1' => __('New Order'),
                    '2' => __('Pending Captain Accept'),
                    '3' => __('Captain Cancelled'),
                    '4' => __('On The Way To Customer'),
                    '5' => __('Delivered'),
                    '6' => __('Completed'),
                    '-1' => __('Rejected By Merchant'),
                    '-2' => __('Captain Cancelled'),
                ]),

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
        return 'backend.order.includes.row';
    }
}
