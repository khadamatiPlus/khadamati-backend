@extends('backend.layouts.app')

@section('title', __('Banners Management'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Banners Management')
        </x-slot>

        @if ($logged_in_user->hasAllAccess() ||$logged_in_user->can('admin.banner.store') )
            <x-slot name="headerActions">
                <x-utils.link
                    icon="c-icon cil-plus"
                    class="card-header-action"
                    :href="route('admin.banner.create')"
                    :text="__('Create Banner')"
                />
            </x-slot>
        @endif
        <x-slot name="body">
            @livewire('banner-table')
        </x-slot>
    </x-backend.card>
@endsection
