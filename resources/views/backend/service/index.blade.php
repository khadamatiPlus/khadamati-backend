@extends('backend.layouts.app')

@section('title', __('Services Management'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Services Management')
        </x-slot>

        @if ($logged_in_user->hasAllAccess() ||$logged_in_user->can('admin.service.store') )
            <x-slot name="headerActions">
                <x-utils.link
                    icon="c-icon cil-plus"
                    class="card-header-action"
                    :href="route('admin.service.create')"
                    :text="__('Create Service')"
                />
            </x-slot>
        @endif
        <x-slot name="body">
            @livewire('service-table')
        </x-slot>
    </x-backend.card>
@endsection
