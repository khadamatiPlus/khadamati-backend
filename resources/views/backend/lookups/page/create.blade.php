@extends('backend.layouts.app')

@section('title', __('Create Page'))

@section('content')
    <x-forms.post :action="route('admin.lookups.page.store')">
        <x-backend.card>
            <x-slot name="header">
                @lang('Create Page')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.lookups.page.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">

                <div class="form-group row">
                    <label for="title" class="col-md-2 col-form-label">@lang('Title')</label>

                    <div class="col-md-10">
                        <input name="title" id="title" class="form-control" required/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="title_ar" class="col-md-2 col-form-label">@lang('Arabic Title')</label>

                    <div class="col-md-10">
                        <input name="title_ar" id="title_ar" class="form-control" required/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="description" class="col-md-2 col-form-label">@lang('Description')</label>

                    <div class="col-md-10">
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="description_ar" class="col-md-2 col-form-label">@lang('Arabic Description')</label>

                    <div class="col-md-10">
                        <textarea name="description_ar" id="description_ar" class="form-control"></textarea>
                    </div>
                </div><!--form-group-->

            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Page')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
