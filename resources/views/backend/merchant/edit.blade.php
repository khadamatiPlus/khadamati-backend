@inject('model', '\App\Domains\Merchant\Models\Merchant')

@extends('backend.layouts.app')

@section('title', __('Update Merchant'))

@section('content')
    <x-forms.post :action="route('admin.merchant.update', $merchant)" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="PATCH" />
        <input type="hidden" name="id" value="{{$merchant->id}}" />
        <input type="hidden" name="owner_id" value="{{$merchant->profile_id}}" />
        <x-backend.card>
            <x-slot name="header">
                @lang('Update Merchant')
            </x-slot>
            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.merchant.index')" :text="__('Cancel')" />
            </x-slot>
            <x-slot name="body">
                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label">@lang('Name')</label>

                    <div class="col-md-10">
                        <input name="name" id="name" class="form-control" value="{{ old('name') ?? $merchant->name }}" required/>
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="profile_pic" class="col-md-2 col-form-label">@lang('Profile Pic')</label>
                    <div class="col-md-10">
                        <input type="file" name="profile_pic" id="profile_pic" class="form-control"/>
                        <img id="profile_pic_blah" src="{{storageBaseLink(\App\Enums\Core\StoragePaths::MERCHANT_PROFILE_PIC.$merchant->profile_pic)}}" class="@if(!isset($merchant->profile_pic)) d-none @endif mt-2" width="100" height="100" loading="lazy" />
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="city_id" class="col-md-2 col-form-label">@lang('City')</label>
                    <div class="col-md-10">
                        <select name="city_id" id="city_id" class="form-control" required>
                            @foreach ($cities as $value)
                                @if($value->id == $merchant->city_id)
                                    <option value="{{$value->id}}" selected>{{$value->name}}</option>
                                @else
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="latitude" class="col-md-2 col-form-label">@lang('Latitude')</label>
                    <div class="col-md-10">
                        <input name="latitude" id="latitude" value="{{old('latitude') ?? $merchant->latitude}}" class="form-control" required step="any" min="-90" max="90"/>
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="longitude" class="col-md-2 col-form-label">@lang('Longitude')</label>
                    <div class="col-md-10">
                        <input name="longitude" id="longitude" value="{{old('longitude') ?? $merchant->longitude}}" class="form-control" required step="any" min="-180" max="180"/>
                    </div>
                </div><!--form-group-->

{{--                <div class="form-group row">--}}
{{--                    <label for="business_type_id" class="col-md-2 col-form-label">@lang('Business Type')</label>--}}
{{--                    <div class="col-md-10">--}}
{{--                        <select name="business_type_id" id="business_type_id" value="{{old('business_type_id')}}" class="form-control" required>--}}
{{--                            <option value="" selected disabled>@lang('-- Select --')</option>--}}
{{--                            @foreach ($businessTypes as $value)--}}
{{--                                @if($value->id==$merchant->business_type_id)--}}
{{--                                    <option selected value="{{$value->id}}">{{$value->name}}</option>--}}
{{--                                @else--}}
{{--                                    <option value="{{$value->id}}">{{$value->name}}</option>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </x-slot>
            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update Merchant')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
@push('after-scripts')
    <script>
        $( document ).ready(function() {
            $('#is_verified').on('change', function(){
                this.value = this.checked ? 'yes' : 'no';
                var ccc = this.value;
            }).change();
        });

        $( document ).ready(function() {
            $('#is_verified').on('change', function(){
                this.value = this.checked ? 1 : 0;
            }).change();
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#profile_pic_blah').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#profile_pic").change(function(){
            $('#profile_pic_blah').removeClass('d-none');
            readURL(this);
        });

    </script>
@endpush
