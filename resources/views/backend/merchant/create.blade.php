@extends('backend.layouts.app')
@section('title', __('Create Merchant'))
@section('content')
    <x-forms.post :action="route('admin.merchant.store')" enctype="multipart/form-data">
        <x-backend.card>
            <x-slot name="header">
                @lang('Create Merchant')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.merchant.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">

                <div class="form-group row">
                    <label for="mobile_number" class="col-md-2 col-form-label">@lang('Mobile Number')</label>
                    <div class="col-md-10">
                        <input name="mobile_number" id="mobile_number" class="form-control"  value="{{old('mobile_number')}}" required/>
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label">@lang('Name')</label>

                    <div class="col-md-10">
                        <input name="name" id="name" value="{{old('name')}}" class="form-control" required/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="profile_pic" class="col-md-2 col-form-label">@lang('Profile Pic')</label>
                    <div class="col-md-10">
                        <input onchange="readURL(this)" type="file" name="profile_pic" id="profile_pic" class="form-control"  accept="image/*" />
                        <img  class="mt-2 d-none" id="profile_pic-blah" height="100px" width="100px"  alt="{{old('profile_pic')}}" />
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="city_id" class="col-md-2 col-form-label">@lang('City')</label>
                    <div class="col-md-10">
                        <select name="city_id" value="{{old('city_id')}}" id="city_id" class="form-control" required>
                            <option value="" selected disabled>@lang('-- Select --')</option>
                            @foreach ($cities as $value)
                                @if($value->id==old('city_id'))
                               <option selected  value="{{$value->id}}">{{$value->name}}</option>
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
                        <input name="latitude" id="latitude" value="{{old('latitude')}}" class="form-control" required step="any" min="-90" max="90"/>
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="longitude" class="col-md-2 col-form-label">@lang('Longitude')</label>
                    <div class="col-md-10">
                        <input name="longitude" id="longitude" value="{{old('longitude')}}" class="form-control" required step="any" min="-180" max="180"/>
                    </div>
                </div><!--form-group-->

{{--                <div class="form-group row">--}}
{{--                    <label for="business_type_id" class="col-md-2 col-form-label">@lang('Business Type')</label>--}}
{{--                <div class="col-md-10">--}}
{{--                    <select name="business_type_id" id="business_type_id" value="{{old('business_type_id')}}" class="form-control" required>--}}
{{--                        <option value="" selected disabled>@lang('-- Select --')</option>--}}
{{--                        @foreach ($businessTypes as $value)--}}
{{--                            @if($value->id==old('business_type_id'))--}}
{{--                            <option selected value="{{$value->id}}">{{$value->name}}</option>--}}
{{--                            @else--}}
{{--                                <option value="{{$value->id}}">{{$value->name}}</option>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                </div>--}}
{{-- </div>--}}


{{--                <div class="form-group row">--}}
{{--                    <label for="is_verified" class="col-md-2 col-form-label">@lang('Is Verified')</label>--}}

{{--                    <div class="col-md-1">--}}
{{--                        <input type="checkbox"  {{old('is_verified')==1?'checked':""}}  name="is_verified" id="is_verified" value="0" />--}}
{{--                    </div>--}}
{{--                </div><!--form-group-->--}}

            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Merchant')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
@push('after-scripts')
    <script>
        $( document ).ready(function() {
            $('#is_verified').on('change', function(){
                this.value = this.checked ? 1 : 0;
            }).change();
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#profile_pic-blah').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#profile_pic").change(function(){
            $('#profile_pic-blah').removeClass('d-none');
            readURL(this);
        });
        $('#mobile_number').keyup(function () {
            if (!this.value.match(/^(\d|-)+$/)) {
                this.value = this.value.replace(/[^0-9-+]/g, '');
            }
        });

    </script>
@endpush
