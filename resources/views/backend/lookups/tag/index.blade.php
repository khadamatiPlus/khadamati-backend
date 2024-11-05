@extends('backend.layouts.app')

@section('title', __('Tag Management'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Tag Management')
        </x-slot>

        @if ($logged_in_user->hasAllAccess()||$logged_in_user->can('admin.lookups.tag.store') )
            <x-slot name="headerActions">
                <x-utils.link
                    icon="c-icon cil-plus"
                    class="card-header-action"
                    :href="route('admin.lookups.tag.create')"
                    :text="__('Create Tag')"
                />
            </x-slot>
        @endif
        <x-slot name="body">
            @livewire('tag-table')
        </x-slot>
    </x-backend.card>
@endsection
