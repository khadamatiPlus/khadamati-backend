@extends('backend.layouts.app')
@section('title', __('View Merchant'))
@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('View Merchant')
        </x-slot>
        <x-slot name="headerActions">
            <x-utils.link class="card-header-action" :href="route('admin.merchant.index')" :text="__('Back')" />
        </x-slot>
        <x-slot name="body">
            <table class="table table-hover">
                <tr>
                    <th>@lang('Name')</th>
                    <td>{{$merchant->name}}</td>
                </tr>
                <tr>
                    <th>@lang('Mobile Number')</th>
                    <td>
                        @if(!empty($merchant->profile->mobile_number))
                            <a href = "tel: {{ $merchant->profile->mobile_number }}">{{ $merchant->profile->mobile_number }}</a>
                        @else
                            @lang('Empty')
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>@lang('Email')</th>
                    <td>
                        @if(!empty($merchant->profile->email))
                            <a href = "mailto: {{ $merchant->profile->email }}">{{ $merchant->profile->email }}</a>
                        @else
                            @lang('Empty')
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>@lang('Merchant Profile Pic')</th>
                    <td>
                        @if(!empty($merchant->profile_pic))
                            <img src="{{storageBaseLink(\App\Enums\Core\StoragePaths::MERCHANT_PROFILE_PIC.$merchant->profile_pic)}}" width="50" height="50" loading="lazy" onerror="this.src='{{ asset('img/brand/default.png') }}'" />
                        @else
                            @lang('No Merchant Profile Pic')
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>@lang('Merchant Country')</th>
                    <td>{{ $merchant->country->name }}</td>
                </tr>
                <tr>
                    <th>@lang('Merchant City')</th>
                    <td>{{ $merchant->city->name }}</td>
                </tr>
                <tr>
                    <th>@lang('Merchant Area')</th>
                    <td>{{ $merchant->area->name }}</td>
                </tr>
                <tr>
                    <th>@lang('Merchant Location')</th>
                    <td><a href="https://maps.google.com/?q= {{ $merchant->latitude}},{{ $merchant->longitude}}" target="_blank">{{__("View In Map")}}</a></td>
                </tr>
                <tr>
                    <th>@lang('Created By')</th>
                    <td>{{$merchant->createdById->name??"Not Found"}}</td>
                </tr>
            </table>
        </x-slot>
        <x-slot name="footer">
            <small class="float-right text-muted">
                <strong>@lang('Merchant Created'):</strong> {{ $merchant->created_at->format('Y-m-d H:i:s') }} ({{ $merchant->created_at->diffForHumans() }}),
                <strong>@lang('Last Updated'):</strong> {{ $merchant->updated_at->format('Y-m-d H:i:s') }} ({{ $merchant->updated_at->diffForHumans() }})
                @if($merchant->trashed())
                    <strong>@lang('Account Deleted'):</strong> {{ $merchant->deleted_at->format('Y-m-d H:i:s') }} ({{ $merchant->deleted_at->diffForHumans() }})
                @endif
            </small>

        </x-slot>
    </x-backend.card>
@endsection
