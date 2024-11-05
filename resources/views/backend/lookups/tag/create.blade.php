@extends('backend.layouts.app')

@section('title', __('Create Tag'))

@section('content')
    <x-forms.post :action="route('admin.lookups.tag.store')">
        <x-backend.card>
            <x-slot name="header">
                @lang('Create Tag')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.lookups.tag.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">

                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label">@lang('Name (EN)')</label>

                    <div class="col-md-10">
                        <input name="name" id="name"  value="{{ old('name')}}" class="form-control" required/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="name_ar" class="col-md-2 col-form-label">@lang('Name (AR)')</label>

                    <div class="col-md-10">
                        <input name="name_ar" id="name_ar" value="{{ old('name_ar')}}" class="form-control" required/>
                    </div>
                </div>




            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Tag')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
