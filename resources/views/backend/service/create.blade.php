@extends('backend.layouts.app')
@section('title', __('Create Banner'))
@section('content')
    <x-forms.post :action="route('admin.banner.store')" enctype="multipart/form-data">
        <x-backend.card>
            <x-slot name="header">
                @lang('Create Banner')
            </x-slot>
            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.banner.index')" :text="__('Cancel')" />
            </x-slot>
            <x-slot name="body">

                <div class="form-group row">
                    <label for="merchant_id" class="col-md-2 col-form-label">@lang('Merchant')</label>
                    <div class="col-md-10">
                        <select  name="merchant_id" id="merchant_id" class="form-control " required>
                            <option value="" selected disabled>@lang('-- Select --')</option>
                            @foreach ($merchants as $value)
                                <option  value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="country_id" class="col-md-2 col-form-label">@lang('Country')</label>
                    <div class="col-md-10">
                        <select  name="country_id" id="country_id" class="form-control " required>
                            <option value="" selected disabled>@lang('-- Select --')</option>
                            @foreach ($countries as $value)
                                <option  value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="image" class="col-md-2 col-form-label">@lang('Image')</label>
                    <div class="col-md-10">
                        <input type="file" name="image" id="image" class="form-control" required />
                        <img class="mt-2 d-none" id="blah" height="100px" width="100px"  alt="{{old('image')}}" />
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
                    <label for="link" class="col-md-2 col-form-label">@lang('Link')</label>
                    <div class="col-md-10">
                        <input type="text" value="{{old('link')}}" name="link" id="link" class="form-control" required />
                    </div>
                </div><!--form-group-->


            </x-slot>
            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Banner')</button>
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
