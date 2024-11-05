<?php
namespace App\Http\Livewire\Backend;

use App\Domains\Lookups\Models\City;
use App\Domains\Lookups\Models\Page;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use function view;


class PageTable extends DataTableComponent
{
    //public bool $perPageAll = true;
//    public int $perPage = 50;

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            Column::make(__('Title'), 'title')
                ->searchable()
                ->sortable(),
            Column::make(__('Arabic Title'), 'title_ar')
                ->searchable()
                ->sortable(),
            Column::make(__('Description'), 'description')
                ->searchable()
                ->sortable(),
            Column::make(__('Arabic Description'), 'description_ar')
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
        return Page::query()->orderByDesc('created_at');
    }

    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'backend.lookups.page.includes.row';
    }
}
