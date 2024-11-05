@inject('model', '\App\Domains\Lookups\Models\Label')

@extends('backend.layouts.app')

@section('title', __('Update Label'))

@section('content')
    <x-forms.post :action="route('admin.lookups.label.update', $label)">
        <input type="hidden" name="_method" value="PATCH" />
        <x-backend.card>
            <x-slot name="header">
                @lang('Update Label')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.lookups.label.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">
                <input type="hidden" name="id" value="{{$label->id}}" />
                <div class="form-group row">
                    <label for="key" class="col-md-2 col-form-label">@lang('Key')</label>
                    <div class="col-md-10">
                        <input readonly name="key" id="key" class="form-control" value="{{ old('key') ?? $label->key }}" required/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="value" class="col-md-2 col-form-label">@lang('Value (EN)')</label>
                    <div class="col-md-10">
                        <input name="value" id="value" class="form-control" value="{{ old('value') ?? $label->value }}" required/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="value_ar" class="col-md-2 col-form-label">@lang('Value (AR)')</label>

                    <div class="col-md-10">
                        <input name="value_ar" id="value_ar" class="form-control" value="{{ old('value_ar') ?? $label->value_ar }}" required/>
                    </div>
                </div><!--form-group-->


            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update Label')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
