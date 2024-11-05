@inject('model', '\App\Domains\Lookups\Models\Tag')

@extends('backend.layouts.app')

@section('title', __('Update Tag'))

@section('content')
    <x-forms.post :action="route('admin.lookups.tag.update', $tag)">
        <input type="hidden" name="_method" value="PATCH" />
        <x-backend.card>
            <x-slot name="header">
                @lang('Update Tag')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.lookups.tag.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">
                <input type="hidden" name="id" value="{{$tag->id}}" />

                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label">@lang('Name (EN)')</label>

                    <div class="col-md-10">
                        <input name="name" id="name" class="form-control" value="{{ old('name') ?? $tag->name }}" required/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="name_ar" class="col-md-2 col-form-label">@lang('Name (AR)')</label>

                    <div class="col-md-10">
                        <input name="name_ar" id="name_ar" class="form-control" value="{{ old('name_ar') ?? $tag->name_ar }}" required/>
                    </div>
                </div><!--form-group-->
            </x-slot>
            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update Tag')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
