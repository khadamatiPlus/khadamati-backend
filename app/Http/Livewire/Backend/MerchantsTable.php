<?php
namespace App\Http\Livewire\Backend;
use App\Domains\Lookups\Models\Category;
use App\Domains\Merchant\Models\Merchant;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Filter;
use App\Domains\Lookups\Models\City;
use function view;
class MerchantsTable extends DataTableComponent
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
                ->searchable(),
            Column::make(__('Mobile Number')),
            Column::make(__('Merchant Picture')),
            Column::make(__('Merchant City')),
            Column::make(__('Merchant Business Type')),
            Column::make(__('Is Verified'),'is_verified'),
            Column::make(__('Actions'))
        ];
    }
    /**
     * @return Builder
     */
    public function query(): Builder
    {
        $query = Merchant::query()
            ->when($this->getFilter('cityFilter'), fn ($query, $cityFilter) => $query->where('city_id', $cityFilter))
            ->when($this->getFilter('isVerifiedFilter'), fn ($query, $isVerifiedFilter) => $isVerifiedFilter === 'true' ? $query->where('is_verified', 1) : $query->where('is_verified', 0))
            ->orderByDesc('created_at');
        return $query;
    }
    public function filters(): array
    {
        return [
            'cityFilter' => Filter::make(__('City'))
                ->select(City::query()
                    ->select(['id','name'])
                    ->get()
                    ->prepend((object)[
                        'id' => '',
                        'name' => __('All')
                    ])
                    ->pluck('name','id')->toArray()),
            'isVerifiedFilter' => Filter::make('Is Verified')
                ->select([
                    '' => __('All'),
                    'true' => __('Verified'),
                    'false' => __('Unverified'),
                ]),
        ];
    }
    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'backend.merchant.includes.row';
    }
}
