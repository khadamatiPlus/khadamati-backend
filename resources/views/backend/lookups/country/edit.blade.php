@inject('model', '\App\Domains\Lookups\Models\Country')

@extends('backend.layouts.app')

@section('title', __('Update Country'))

@section('content')
    <x-forms.post :action="route('admin.lookups.country.update', $country)">
        <input type="hidden" name="_method" value="PATCH" />
        <x-backend.card>
            <x-slot name="header">
                @lang('Update Country')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.lookups.country.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">
                <input type="hidden" name="id" value="{{$country->id}}" />

                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label">@lang('Name')</label>

                    <div class="col-md-10">
                        <input name="name" id="name" class="form-control" value="{{ old('name') ?? $country->name }}" required/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="name_ar" class="col-md-2 col-form-label">@lang('Arabic Name')</label>

                    <div class="col-md-10">
                        <input name="name_ar" id="name_ar" class="form-control" value="{{ old('name_ar') ?? $country->name_ar }}" required/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="code" class="col-md-2 col-form-label">@lang('Code')</label>

                    <div class="col-md-10">
                        <input name="code" id="code" class="form-control" placeholder="@lang('ex: JO')" value="{{ old('code') ?? $country->code }}" required/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="phone_code" class="col-md-2 col-form-label">@lang('Phone Code')</label>

                    <div class="col-md-10">
                        <input name="phone_code" id="phone_code" class="form-control" value="{{ old('phone_code') ?? $country->phone_code }}" required/>
                    </div>
                </div><!--form-group-->

            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update Country')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
