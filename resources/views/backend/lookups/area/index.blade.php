@extends('backend.layouts.app')

@section('title', __('Area Management'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Area Management')
        </x-slot>

        @if ($logged_in_user->hasAllAccess() ||$logged_in_user->can('admin.lookups.area.store') )
            <x-slot name="headerActions">
                <x-utils.link
                    icon="c-icon cil-plus"
                    class="card-header-action"
                    :href="route('admin.lookups.area.create')"
                    :text="__('Create Area')"
                />
            </x-slot>
        @endif
        <x-slot name="body">
            @livewire('area-table')
        </x-slot>
    </x-backend.card>
@endsection
