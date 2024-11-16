@extends('backend.layouts.app')
@section('title', __('Create Introduction'))
@section('content')
    <x-forms.post :action="route('admin.introduction.store')" enctype="multipart/form-data">
        <x-backend.card>
            <x-slot name="header">
                @lang('Create Introduction')
            </x-slot>
            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.introduction.index')" :text="__('Cancel')" />
            </x-slot>
            <x-slot name="body">
                <div class="form-group row">
                    <label for="image" class="col-md-2 col-form-label">@lang('Image')</label>
                    <div class="col-md-10">
                        <input type="file" name="image" id="image" class="form-control" required />
                        <img class="mt-2 d-none" id="blah" height="100px" width="100px"  alt="{{old('image')}}" />
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="title" class="col-md-2 col-form-label">@lang('Title (EN)')</label>
                    <div class="col-md-10">
                        <input type="text" value="{{old('title')}}" name="title" id="title" class="form-control" required />
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="title_ar" class="col-md-2 col-form-label">@lang('Title (AR)')</label>
                    <div class="col-md-10">
                        <input type="text" value="{{old('title_ar')}}" name="title_ar" id="title_ar" class="form-control" required />
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="description" class="col-md-2 col-form-label">@lang('Description (EN)')</label>
                    <div class="col-md-10">
                        <textarea name="description" id="description" class="form-control">{{old('description')}}</textarea>
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="description_ar" class="col-md-2 col-form-label">@lang('Description (AR)')</label>
                    <div class="col-md-10">
                        <textarea name="description_ar" id="description_ar" class="form-control">{{old('description_ar')}}</textarea>
                    </div>
                </div><!--form-group-->


            </x-slot>
            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Introduction')</button>
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
        $("#image").change(function(){
            $('#blah').removeClass('d-none');
            readURL(this);
        });
    </script>
@endpush
