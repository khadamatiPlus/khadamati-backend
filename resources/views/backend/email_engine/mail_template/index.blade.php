@extends('backend.layouts.app')

@section('title', __('Mail Template Management'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Mail Template Management')
        </x-slot>

        <x-slot name="body">
            <livewire:backend.mail-templates-table />
        </x-slot>
    </x-backend.card>
@endsection
