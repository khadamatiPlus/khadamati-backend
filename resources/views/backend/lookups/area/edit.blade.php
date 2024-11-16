@inject('model', '\App\Domains\Lookups\Models\Area')

@extends('backend.layouts.app')

@section('title', __('Update Area'))

@section('content')
    <x-forms.post :action="route('admin.lookups.area.update', $area)">
        <input type="hidden" name="_method" value="PATCH" />
        <x-backend.card>
            <x-slot name="header">
                @lang('Update Area')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.lookups.area.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">
                <input type="hidden" name="id" value="{{$area->id}}" />

                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label">@lang('Name (EN)')</label>

                    <div class="col-md-10">
                        <input name="name" id="name" class="form-control" value="{{ old('name') ?? $area->name }}" required/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="name_ar" class="col-md-2 col-form-label">@lang('Name (AR)')</label>

                    <div class="col-md-10">
                        <input name="name_ar" id="name_ar" class="form-control" value="{{ old('name_ar') ?? $area->name_ar }}" required/>
                    </div>
                </div><!--form-group-->

{{--                <div class="form-group row ">--}}
{{--                    <label for="country_id" class="col-md-2 col-form-label">@lang('Country')</label>--}}

{{--                    <div class="col-md-10">--}}
{{--                        <select name="country_id" id="country_id" class="form-control" required>--}}
{{--                            @foreach ($countries as $value)--}}
{{--                                @if($value->id == $city->country_id)--}}
{{--                                    <option value="{{$value->id}}" selected>{{$value->name}}</option>--}}
{{--                                @else--}}
{{--                                    <option value="{{$value->id}}">{{$value->name}}</option>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                </div><!--form-group-->--}}
                <div class="form-group row ">
                    <label for="city_id" class="col-md-2 col-form-label">@lang('City')</label>

                    <div class="col-md-10">
                        <select name="city_id" id="country_id" class="form-control" required>
                            @foreach ($cities as $value)
                                @if($value->id == $area->city_id)
                                    <option value="{{$value->id}}" selected>{{$value->name}}</option>
                                @else
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div><!--form-group-->

            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update Area')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
