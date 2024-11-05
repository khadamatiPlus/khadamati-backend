@extends('backend.layouts.app')

@section('title', __('Send Custom Email'))

@section('content')
    <x-forms.post :action="route('admin.emailEngine.sender.doSendToSiteAdmins')">
        <x-backend.card>
            <x-slot name="header">
                @lang('Send custom email to site admins')
            </x-slot>

            <x-slot name="body">
                <div class="form-group row">
                    <label for="to" class="col-md-2 col-form-label">@lang('To')</label>

                    <div class="col-md-10">
                        <select class="form-control" name="to[]" multiple data-placeholder="{{__('Click here to select recipients')}}">
                            @foreach($siteAdmins as $siteAdmin)
                                <option value="{{$siteAdmin->id}}">{{$siteAdmin->name}} ({{$siteAdmin->email}})</option>
                            @endforeach
                        </select>
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="subject" class="col-md-2 col-form-label">@lang('Subject')</label>

                    <div class="col-md-10">
                        <input class="form-control" name="subject" id="subject" placeholder="{{__('Subject')}}" />
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="html_template" class="col-md-2 col-form-label">@lang('Body')</label>

                    <div class="col-md-10">
                        <textarea class="swal2-textarea" rows="5" name="body" id="body"></textarea>
                    </div>
                </div><!--form-group-->
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Send')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection


