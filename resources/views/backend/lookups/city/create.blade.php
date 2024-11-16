@extends('backend.layouts.app')

@section('title', __('Create City'))

@section('content')
    <x-forms.post :action="route('admin.lookups.city.store')">
        <x-backend.card>
            <x-slot name="header">
                @lang('Create City')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.lookups.city.index')" :text="__('Cancel')" />
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
                    <label for="country_id" class="col-md-2 col-form-label">@lang('Country')</label>

                    <div class="col-md-10">
                        <select  name="country_id" id="country_id" class="form-control " required>
                            <option value="" selected disabled>@lang('-- Select --')</option>
                            @foreach ($countries as $value)
                               <option  value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div><!--form-group-->


            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create City')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
