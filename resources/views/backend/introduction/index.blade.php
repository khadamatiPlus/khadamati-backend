@extends('backend.layouts.app')

@section('title', __('Introductions Management'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Introductions Management')
        </x-slot>

        @if ($logged_in_user->hasAllAccess() ||$logged_in_user->can('admin.introduction.store') )
            <x-slot name="headerActions">
                <x-utils.link
                    icon="c-icon cil-plus"
                    class="card-header-action"
                    :href="route('admin.introduction.create')"
                    :text="__('Create Introduction')"
                />
            </x-slot>
        @endif
        <x-slot name="body">
            @livewire('introduction-table')
        </x-slot>
    </x-backend.card>
@endsection
