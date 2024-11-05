@extends('backend.layouts.app')

@section('title', __('Order'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Order')
        </x-slot>

        <x-slot name="body">
            <livewire:backend.orders-table />
        </x-slot>
    </x-backend.card>
@endsection
