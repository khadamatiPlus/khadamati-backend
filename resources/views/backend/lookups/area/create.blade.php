@extends('backend.layouts.app')
@section('title', __('Create Area'))
@section('content')
    <x-forms.post :action="route('admin.lookups.area.store')">
        <x-backend.card>
            <x-slot name="header">
                @lang('Create Area')
            </x-slot>
            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.lookups.area.index')" :text="__('Cancel')" />
            </x-slot>
            <x-slot name="body">
                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label">@lang('Name (EN)')</label>

                    <div class="col-md-10">
                        <input name="name" id="name" class="form-control" required/>
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="name_ar" class="col-md-2 col-form-label">@lang('Name (AR)')</label>

                    <div class="col-md-10">
                        <input name="name_ar" id="name_ar" class="form-control" required/>
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="city_id" class="col-md-2 col-form-label">@lang('City')</label>
                    <div class="col-md-10">
                        <select  name="city_id" id="city_id" class="form-control " required>
                            <option value="" selected disabled>@lang('-- Select --')</option>
                            @foreach ($cities as $value)
                               <option  value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div><!--form-group-->
            </x-slot>
            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Area')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
