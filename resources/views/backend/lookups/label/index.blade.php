@extends('backend.layouts.app')

@section('title', __('Label Management'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Label Management')
        </x-slot>

        @if ($logged_in_user->hasAllAccess() ||$logged_in_user->can('admin.lookups.label.store') )
            <x-slot name="headerActions">
                <x-utils.link
                    icon="c-icon cil-plus"
                    class="card-header-action"
                    :href="route('admin.lookups.label.create')"
                    :text="__('Create Label')"
                />
            </x-slot>
        @endif
        <x-slot name="body">
            @livewire('label-table')
        </x-slot>
    </x-backend.card>
@endsection
