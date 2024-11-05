@extends('backend.layouts.app')

@section('title', __('Page Management'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Page Management')
        </x-slot>

{{--        @if ($logged_in_user->hasAllAccess())--}}
{{--            <x-slot name="headerActions">--}}
{{--                <x-utils.link--}}
{{--                    icon="c-icon cil-plus"--}}
{{--                    class="card-header-action"--}}
{{--                    :href="route('admin.lookups.page.create')"--}}
{{--                    :text="__('Create Page')"--}}
{{--                />--}}
{{--            </x-slot>--}}
{{--        @endif--}}
        <x-slot name="body">
            @livewire('page-table')
        </x-slot>
    </x-backend.card>
@endsection
