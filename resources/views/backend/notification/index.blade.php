@extends('backend.layouts.app')

@section('title', __('Notification Management'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Notification Management')
        </x-slot>

        @if ($logged_in_user->hasAllAccess() ||$logged_in_user->can('admin.notification.store') )
            <x-slot name="headerActions">
                <x-utils.link
                    icon="c-icon cil-plus"
                    class="card-header-action"
                    :href="route('admin.notification.create')"
                    :text="__('Create Notification')"
                />
            </x-slot>
        @endif
        <x-slot name="body">
            @livewire('notification-table')
        </x-slot>
    </x-backend.card>
@endsection
