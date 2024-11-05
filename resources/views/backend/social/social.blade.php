@inject('model', '\App\Domains\Social\Models\Social')

@extends('backend.layouts.app')

@section('title', __('Update Social Media'))

@section('content')
    <x-forms.post :action="route('admin.social.update', $social)" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="PATCH" />
        <x-backend.card>
            <x-slot name="header">
                @lang('Update Social Media')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.dashboard')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">
                <input type="hidden" name="id" value="{{$social->id}}" />
{{--                <div class="form-group row">--}}
{{--                    <label for="x" class="col-md-2 col-form-label">@lang('X')</label>--}}

{{--                    <div class="col-md-10">--}}
{{--                        <input name="x" id="x" value="{{old('x')??$social->twitter}}" class="form-control"/>--}}
{{--                    </div>--}}
{{--                </div><!--form-group-->--}}
{{--                <div class="form-group row">--}}
{{--                    <label for="whatsapp" class="col-md-2 col-form-label">@lang('Whatsapp')</label>--}}

{{--                    <div class="col-md-10">--}}
{{--                        <input name="whatsapp" id="whatsapp" value="{{old('whatsapp')??$social->whatsapp}}" class="form-control"/>--}}
{{--                    </div>--}}
{{--                </div><!--form-group-->--}}
{{--                <div class="form-group row">--}}
{{--                    <label for="tiktok" class="col-md-2 col-form-label">@lang('Tiktok')</label>--}}

{{--                    <div class="col-md-10">--}}
{{--                        <input name="tiktok" id="tiktok" value="{{old('tiktok')??$social->tiktok}}" class="form-control"/>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                    <div class="form-group row">--}}
{{--                        <label for="youtube" class="col-md-2 col-form-label">@lang('Youtube')</label>--}}
{{--                        <div class="col-md-10">--}}
{{--                            <input name="youtube" id="youtube" value="{{old('youtube')??$social->youtube}}" class="form-control"/>--}}
{{--                        </div>--}}
{{--                    </div><!--form-group-->--}}
                    <div class="form-group row">
                        <label for="facebook" class="col-md-2 col-form-label">@lang('Facebook')</label>

                        <div class="col-md-10">
                            <input name="facebook" id="facebook" value="{{old('facebook')??$social->facebook}}" class="form-control"/>
                        </div>
                    </div><!--form-group-->
                    <div class="form-group row">
                        <label for="instagram" class="col-md-2 col-form-label">@lang('Instagram')</label>

                        <div class="col-md-10">
                            <input name="instagram" id="instagram" value="{{old('instagram')??$social->instagram}}" class="form-control"/>
                        </div>
                    </div><!--form-group-->
{{--                <div class="form-group row">--}}
{{--                    <label for="snapchat" class="col-md-2 col-form-label">@lang('Snapchat')</label>--}}

{{--                    <div class="col-md-10">--}}
{{--                        <input name="snapchat" id="snapchat" value="{{old('snapchat')??$social->snapchat}}" class="form-control"/>--}}
{{--                    </div>--}}
{{--                </div><!--form-group-->--}}
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update Social Media')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
