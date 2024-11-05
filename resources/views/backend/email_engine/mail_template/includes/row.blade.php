<x-livewire-tables::bs4.table.cell>
    {!! substr($row->mailable, strrpos($row->mailable, '\\') + 1) !!}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {!! $row->subject !!}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {!! $row->html_template !!}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
@include('backend.email_engine.mail_template.includes.actions', ['model' => $row])
</x-livewire-tables::bs4.table.cell>
