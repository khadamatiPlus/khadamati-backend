@extends('backend.layouts.app')
@section('title', __('Categories Management'))
@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Categories Management')
        </x-slot>
        @if ($logged_in_user->hasAllAccess())
            <x-slot name="headerActions">
                <x-utils.link
                    icon="c-icon cil-plus"
                    class="card-header-action"
                    :href="route('admin.lookups.category.create')"
                    :text="__('Create Category')"
                />
            </x-slot>
        @endif
        <x-slot name="body">
            @livewire('category-table')
        </x-slot>
    </x-backend.card>
@endsection
