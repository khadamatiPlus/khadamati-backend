@extends('backend.layouts.app')
@section('title', __('Create Notification'))
@section('content')
    <x-forms.post :action="route('admin.notification.store')" enctype="multipart/form-data">
        <x-backend.card>
            <x-slot name="header">
                @lang('Create Notification')
            </x-slot>
            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.notification.index')" :text="__('Cancel')" />
            </x-slot>
            <x-slot name="body">
                <div class="form-group row">
                    <label for="slider_image" class="col-md-2 col-form-label">@lang('Notification Icon')</label>
                    <div class="col-md-10">
                        <input type="file" name="notification_icon" id="notification_icon" class="form-control" required />
                        <img class="mt-2 d-none" id="blah" height="100px" width="100px"  alt="{{old('notification_icon')}}" />
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="title" class="col-md-2 col-form-label">@lang('Title (English)')</label>
                    <div class="col-md-10">
                        <input type="text" value="{{old('title')}}" name="title" id="title" class="form-control" required />
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="title_ar" class="col-md-2 col-form-label">@lang('Title (Arabic)')</label>
                    <div class="col-md-10">
                        <input type="text" value="{{old('title_ar')}}" name="title_ar" id="title_ar" class="form-control" required />
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="description" class="col-md-2 col-form-label">@lang('Description (English)')</label>
                    <div class="col-md-10">
                        <input type="text" value="{{old('description')}}" name="description" id="description" class="form-control" required />
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="description_ar" class="col-md-2 col-form-label">@lang('Description (Arabic)')</label>
                    <div class="col-md-10">
                        <input type="text" value="{{old('description_ar')}}" name="description_ar" id="description_ar" class="form-control" required />
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="type" class="col-md-2 col-form-label">@lang('Type')</label>
                    <div class="col-md-10">
                        <select name="type"  id="type" class="form-control" required>
                            <option value="" selected disabled>@lang('-- Select --')</option>
                                    <option  value="merchant">{{__("Merchants")}}</option>
                                     <option  value="user">{{__("Users")}}</option>
                        </select>
                    </div>
                </div><!--form-group-->


            </x-slot>
            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Notification')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
@push('after-scripts')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#notification_icon").change(function(){
            $('#blah').removeClass('d-none');
            readURL(this);
        });
    </script>
@endpush
