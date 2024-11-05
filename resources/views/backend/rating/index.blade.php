@extends('backend.layouts.app')

@section('title', __('Rating'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Rating')
        </x-slot>

        <x-slot name="body">
            <livewire:backend.ratings-table />
        </x-slot>
    </x-backend.card>
@endsection
