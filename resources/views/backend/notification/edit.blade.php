@inject('model', '\App\Domains\Notification\Models\Notification')

@extends('backend.layouts.app')

@section('title', __('Update Notification'))

@section('content')
    <x-forms.post :action="route('admin.notification.update', $notification)" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="PATCH" />
        <x-backend.card>
            <x-slot name="header">
                @lang('Update Notification')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.notification.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">
                <input type="hidden" name="id" value="{{$notification->id}}" />
                <div class="form-group row">
                    <label for="notification_icon" class="col-md-2 col-form-label">@lang('Notification Icon')</label>
                    <div class="col-md-10">
                        <input type="file" name="notification_icon" id="notification_icon" class="form-control" />
                        <img src="{{storageBaseLink(\App\Enums\Core\StoragePaths::NOTIFICATION_ICON.$notification->notification_icon)}}" class="mt-2" id="blah" height="100px" width="100px"  alt="{{old('notification_icon')}}" />
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="title" class="col-md-2 col-form-label">@lang('Title (English)')</label>
                    <div class="col-md-10">
                        <input type="text" value="{{$notification->title??old('title')}}" name="title" id="title" class="form-control" required />
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="title_ar" class="col-md-2 col-form-label">@lang('Title (Arabic)')</label>
                    <div class="col-md-10">
                        <input type="text" value="{{$notification->title_ar??old('title_ar')}}" name="title_ar" id="title_ar" class="form-control" required />
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="description" class="col-md-2 col-form-label">@lang('Description (English)')</label>
                    <div class="col-md-10">
                        <input type="text" value="{{$notification->description??old('description')}}" name="description" id="description" class="form-control" required />
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="description_ar" class="col-md-2 col-form-label">@lang('Description (Arabic)')</label>
                    <div class="col-md-10">
                        <input type="text" value="{{$notification->description_ar??old('description_ar')}}" name="description_ar" id="description_ar" class="form-control" required />
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="type" class="col-md-2 col-form-label">@lang('Type')</label>
                    <div class="col-md-10">
                        <select name="type"  id="type" class="form-control" required>
                            <option value="" selected disabled>@lang('-- Select --')</option>
                            <option  @if($notification->type == 'merchant') selected @endif  value="merchant">{{__("Merchants")}}</option>
                            <option  @if($notification->type == 'user') selected @endif  value="captain">{{__("Users")}}</option>
                        </select>
                    </div>
                </div><!--form-group-->


            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update Notification')</button>
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
