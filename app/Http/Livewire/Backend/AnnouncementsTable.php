<?php

namespace App\Http\Livewire\Backend;

use App\Domains\Announcement\Models\Announcement;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class AnnouncementsTable extends DataTableComponent
{

    public function columns(): array
    {
        return [
            Column::make(__('Area'), 'area')
                ->searchable()
                ->sortable(),
            Column::make(__('Type'), 'type')
                ->searchable()
                ->sortable(),
            Column::make(__('Period')),
            Column::make(__('Message'), 'message')
                ->searchable(),
            Column::make(__('Localized Message'), 'message_localized')
                ->searchable(),
            Column::make(__('Actions'))
        ];
    }

    public function query()
    {
        return Announcement::query();
    }

    public function rowView(): string
    {
        return 'backend.announcement.includes.row';
    }
}
