@extends('backend.layouts.app')

@section('title', __('Create Label'))

@section('content')
    <x-forms.post :action="route('admin.lookups.label.store')">
        <x-backend.card>
            <x-slot name="header">
                @lang('Create Label')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.lookups.label.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">

                <div class="form-group row">
                    <label for="key" class="col-md-2 col-form-label">@lang('Key')</label>
                    <div class="col-md-10">
                        <input name="key" id="key" class="form-control" value="{{ old('key') }}" required/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="value" class="col-md-2 col-form-label">@lang('Value (EN)')</label>
                    <div class="col-md-10">
                        <input name="value" id="value" class="form-control" value="{{ old('value') }}" required/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="value_ar" class="col-md-2 col-form-label">@lang('Value (AR)')</label>

                    <div class="col-md-10">
                        <input name="value_ar" id="value_ar" class="form-control" value="{{ old('value_ar')}}" required/>
                    </div>
                </div><!--form-group-->
            </x-slot>
            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Label')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
