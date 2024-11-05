@inject('model', '\App\Domains\Information\Models\Information')
@extends('backend.layouts.app')
@section('title', __('Update Information'))
@section('content')
    <x-forms.post :action="route('admin.information.update', $information)" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="PATCH" />
        <x-backend.card>
            <x-slot name="header">
                @lang('Update Information')
            </x-slot>
            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.dashboard')" :text="__('Cancel')" />
            </x-slot>
            <x-slot name="body">
                <input type="hidden" name="id" value="{{$information->id}}" />
                <div class="form-group row">
                    <label for="email" class="col-md-2 col-form-label">@lang('Email')</label>
                    <div class="col-md-10">
                        <input type="email" name="email" id="email" value="{{old('email')??$information->email}}" class="form-control" />
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="phone_number" class="col-md-2 col-form-label">@lang('Phone Number')</label>
                    <div class="col-md-10">
                        <input name="phone_number" id="phone_number" value="{{old('phone_number')??$information->phone_number}}" class="form-control" />
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="second_phone_number" class="col-md-2 col-form-label">@lang('Second Phone Number')</label>
                    <div class="col-md-10">
                        <input name="second_phone_number" id="second_phone_number" value="{{old('second_phone_number')??$information->second_phone_number}}" class="form-control" />
                    </div>
                </div><!--form-group-->
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update Information')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
