<?php

namespace App\Http\Livewire\Backend;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Spatie\MailTemplates\Models\MailTemplate;

class MailTemplatesTable extends DataTableComponent
{
    public function columns(): array
    {
        return [
            Column::make(__('Template Name'), 'mailable')
                ->searchable()
                ->sortable(),
            Column::make(__('Subject'), 'subject')
                ->searchable()
                ->sortable(),
            Column::make(__('Body'), 'html_template')
                ->searchable()
                ->sortable(),
            Column::make(__('Actions'))
        ];
    }
    public function query()
    {
        return MailTemplate::query();
    }

    public function rowView(): string
    {
        return 'backend.email_engine.mail_template.includes.row';
    }

}
