<?php
namespace App\Http\Livewire\Backend;
use App\Domains\Item\Models\Item;
use App\Domains\Notification\Models\Notification;
use App\Domains\Service\Models\Service;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Filter;
use function view;
class NotificationsTable extends DataTableComponent
{
    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            Column::make(__('Notification Icon'), 'notification_icon'),
            Column::make(__('Title (English)'), 'title')
                ->searchable(),
            Column::make(__('Title (Arabic)'), 'title_ar')
                ->searchable(),
            Column::make(__('Description (English)'), 'description')
                ->searchable(),
            Column::make(__('Description (Arabic)'), 'description_ar')
                ->searchable(),
            Column::make(__('Type'), 'type')
                ->searchable(),
            Column::make(__('Actions'))
        ];
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Notification::query()->orderByDesc('created_at');
    }
    /**
     * @return string
     */
    public function rowView(): string
    {
        return 'backend.notification.includes.row';
    }
}
