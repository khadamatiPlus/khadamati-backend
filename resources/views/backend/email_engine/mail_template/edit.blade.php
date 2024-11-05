@inject('model', 'Spatie\MailTemplates\Models\MailTemplate')

@extends('backend.layouts.app')

@section('title', __('Create Mail Templates'))

@section('content')
    <x-forms.patch :action="route('admin.emailEngine.mailTemplate.update', $mailTemplate)">
        <x-backend.card>
            <x-slot name="header">
                @lang('Update Mail Templates')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.emailEngine.mailTemplate.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">
                <input type="hidden" name="id" value="{{$mailTemplate->id}}" />

                <div class="form-group row">
                    <label for="subject" class="col-md-2 col-form-label">@lang('Subject')</label>

                    <div class="col-md-10">
                        <input class="form-control" name="subject" id="subject" value="{{$mailTemplate->subject}}" />
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="html_template" class="col-md-2 col-form-label">@lang('Body')</label>

                    <div class="col-md-10">
                        <textarea class="swal2-textarea" rows="5" name="html_template" id="html_template">{{$mailTemplate->html_template}}</textarea>
                    </div>
                </div><!--form-group-->
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update Mail Template')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.patch>
@endsection


