@extends('backend.layouts.app')

@section('title', __('Create Country'))

@section('content')
    <x-forms.post :action="route('admin.lookups.country.store')">
        <x-backend.card>
            <x-slot name="header">
                @lang('Create Country')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.lookups.country.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">

                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label">@lang('Name')</label>

                    <div class="col-md-10">
                        <input name="name" id="name" class="form-control" required/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="name_ar" class="col-md-2 col-form-label">@lang('Arabic Name')</label>

                    <div class="col-md-10">
                        <input name="name_ar" id="name_ar" class="form-control" required/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="code" class="col-md-2 col-form-label">@lang('Code')</label>

                    <div class="col-md-10">
                        <input name="code" id="code" class="form-control" placeholder="@lang('ex: JO')" required/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="phone_code" class="col-md-2 col-form-label">@lang('Phone Code')</label>

                    <div class="col-md-10">
                        <input name="phone_code" id="phone_code" class="form-control" required/>
                    </div>
                </div><!--form-group-->

            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Country')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
