@inject('model', '\App\Domains\Lookups\Models\City')

@extends('backend.layouts.app')

@section('title', __('Update City'))

@section('content')
    <x-forms.post :action="route('admin.lookups.city.update', $city)">
        <input type="hidden" name="_method" value="PATCH" />
        <x-backend.card>
            <x-slot name="header">
                @lang('Update City')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.lookups.city.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">
                <input type="hidden" name="id" value="{{$city->id}}" />

                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label">@lang('Name')</label>

                    <div class="col-md-10">
                        <input name="name" id="name" class="form-control" value="{{ old('name') ?? $city->name }}" required/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="name_ar" class="col-md-2 col-form-label">@lang('Arabic Name')</label>

                    <div class="col-md-10">
                        <input name="name_ar" id="name_ar" class="form-control" value="{{ old('name_ar') ?? $city->name_ar }}" required/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row ">
                    <label for="country_id" class="col-md-2 col-form-label">@lang('Country')</label>

                    <div class="col-md-10">
                        <select name="country_id" id="country_id" class="form-control" required>
                            @foreach ($countries as $value)
                                @if($value->id == $city->country_id)
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
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update Country')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
