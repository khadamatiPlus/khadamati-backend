@inject('model', '\App\Domains\Lookups\Models\Page')

@extends('backend.layouts.app')

@section('title', __('Update Page'))

@section('content')
    <x-forms.post :action="route('admin.lookups.page.update', $page)">
        <input type="hidden" name="_method" value="PATCH" />
        <x-backend.card>
            <x-slot name="header">
                @lang('Update Page')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.lookups.page.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">
                <input type="hidden" name="id" value="{{$page->id}}" />

                <div class="form-group row">
                    <label for="title" class="col-md-2 col-form-label">@lang('Title')</label>

                    <div class="col-md-10">
                        <input name="title" id="title" class="form-control" value="{{ old('title') ?? $page->title }}" required/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="title_ar" class="col-md-2 col-form-label">@lang('Arabic Title')</label>

                    <div class="col-md-10">
                        <input name="title_ar" id="title_ar" class="form-control" value="{{ old('title_ar') ?? $page->title_ar }}" required/>
                    </div>
                </div><!--form-group-->


                <div class="form-group row">
                    <label for="description" class="col-md-2 col-form-label">@lang('Description')</label>

                    <div class="col-md-10">
                        <textarea name="description" id="description" class="form-control" required>
                            {{ old('description') ?? $page->description }}
                        </textarea>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="description_ar" class="col-md-2 col-form-label">@lang('Arabic Description')</label>

                    <div class="col-md-10">
                        <textarea name="description_ar" id="description_ar" class="form-control" required>
                            {{ old('description_ar') ?? $page->description_ar }}
                        </textarea>
                    </div>
                </div><!--form-group-->

            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update Page')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
