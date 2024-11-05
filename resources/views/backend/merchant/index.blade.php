@extends('backend.layouts.app')

@section('title', __('Merchant Management'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Merchant Management')
        </x-slot>

        @if ($logged_in_user->hasAllAccess() ||$logged_in_user->can('admin.merchant.store') )
            <x-slot name="headerActions">
                <x-utils.link
                    icon="c-icon cil-plus"
                    class="card-header-action"
                    :href="route('admin.merchant.create')"
                    :text="__('Create Merchant')"
                />
            </x-slot>
        @endif
        <x-slot name="body">
            @livewire('merchant-table')
        </x-slot>
    </x-backend.card>
@endsection
