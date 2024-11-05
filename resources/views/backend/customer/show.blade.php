@extends('backend.layouts.app')
@section('title', __('View Customer'))
@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('View Customer')
        </x-slot>
        <x-slot name="headerActions">
            <x-utils.link class="card-header-action" :href="route('admin.customer.index')" :text="__('Back')" />
        </x-slot>
        <x-slot name="body">
            <table class="table table-hover">
                <tr>
                    <th>@lang('Name')</th>
                    <td>
                        {{ $customer->name }}
                    </td>
                </tr>
                <tr>
                    <th>@lang('Mobile Number')</th>
                    <td>
                        @if(!empty($customer->profile->mobile_number))
                            <a href = "tel: {{ $customer->profile->mobile_number }}">{{ $customer->profile->mobile_number }}</a>
                        @else
                            @lang('Empty')
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>@lang('Created By')</th>
                    <td>{{$customer->createdById->name??"Not Found"}}</td>
                </tr>
                <tr>
                    <th>@lang('Profile Pic')</th>
                    <td>
                    @if(!empty($customer->profile_pic))
                        <a class="btn btn-warning btn-sm" href={{storageBaseLink(\App\Enums\Core\StoragePaths::CAPTAIN_PROFILE_PIC.$customer->profile_pic)}} download>{{__('Download')}}</a>
                    @else
                        @lang('No File')
                    @endif
                    </td>
                </tr>

                <tr>
                <th>@lang('Is Verified')</th>
                    <td>
                        <input type="checkbox" name="is_verified" data-size="sm" id="is_verified" data-toggle="toggle" data-onstyle="primary" onchange="changeCheckBox({{$customer->id}})" value="{{ old($customer->is_verified) ?? ($customer->is_verified == 0)?'no':'yes'}}" {{$customer->is_verified == 1 ? 'checked' : ''}} >
                    </td>
                </tr>
            </table>
        </x-slot>
        <x-slot name="footer">
            <small class="float-right text-muted">
                <strong>@lang('Customer Created'):</strong> @displayDate($customer->created_at) ({{ $customer->created_at->diffForHumans() }}),
                <strong>@lang('Last Updated'):</strong> @displayDate($customer->updated_at) ({{ $customer->updated_at->diffForHumans() }})
                @if($customer->trashed())
                    <strong>@lang('Account Deleted'):</strong> @displayDate($customer->deleted_at) ({{ $customer->deleted_at->diffForHumans() }})
                @endif
            </small>
        </x-slot>
    </x-backend.card>
@endsection
@push('after-scripts')
    <script>
        function changeCheckBox(id){
            debugger
            $.ajax({
                url : '{{route('admin.customer.updateStatusByCustomerId')}}?'+'customerId='+id,
                type:'GET',
                async : false,
                success:function(data){
                    if(data){

                    }
                },
                error:function (xhr){
                    alert(xhr.message);
                }
            })
        }
    </script>
@endpush
