@extends('backend.layouts.app')
@section('title', __('Create Category'))
@section('content')
    <x-forms.post id="form" :action="route('admin.lookups.category.store')" enctype="multipart/form-data">
        <x-backend.card>
            <x-slot name="header">
                @lang('Create Category')
            </x-slot>
            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.lookups.category.index')" :text="__('Cancel')" />
            </x-slot>
            <x-slot name="body">
            <div class="form-group row">
                    <label for="parent_id" class="col-md-2 col-form-label">@lang('Parent')</label>

                    <div class="col-md-10">
                        <select name="parent_id" id="parent_id" class="form-control" required>
                            <option value="0" selected >@lang('Parent')</option>
                            @foreach ($categories as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label">@lang('Name (EN)')</label>
                    <div class="col-md-10">
                        <input name="name" id="name" value="{{old('name')}}" class="form-control" required/>
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="name_ar" class="col-md-2 col-form-label">@lang('Name (AR)')</label>
                    <div class="col-md-10">
                        <input name="name_ar" id="name_ar" value="{{old('name_ar')}}" class="form-control" required/>
                    </div>
                </div><!--form-group-->
                <div class="form-group row" id="hide1">
                    <label for="summary"  class="col-md-2 col-form-label">@lang('Summary (EN)')</label>
                    <div class="col-md-10">
                        <input name="summary" id="summary" value="{{old('summary')}}" class="form-control" />
                    </div>
                </div><!--form-group-->
                <div class="form-group row" id="hide2">
                    <label for="summary_ar" class="col-md-2 col-form-label">@lang('Summary (AR)')</label>
                    <div class="col-md-10">
                        <input name="summary_ar" id="summary_ar" value="{{old('summary_ar')}}" class="form-control" />
                    </div>
                </div><!--form-group-->
                <div class="form-group row" id="hide3">
                    <label for="image" class="col-md-2 col-form-label">@lang('Image')</label>
                    <div class="col-md-10">
                        <input type="file" name="image" id="image" class="form-control" accept="image/*"/>
                        <img class="mt-2 d-none" id="blah" height="100px" width="100px"  alt="{{old('image')}}" />
                    </div>
                </div><!--form-group-->


                <div class="form-group row" id="hide4">
                    <label for="is_featured" class="col-md-2 col-form-label">@lang('Is Featured')</label>
                    <div class="col-md-10">
                        <select name="is_featured" id="is_featured" class="form-control" required>
                            <option value="0" selected >@lang('No')</option>
                            <option value="1">@lang('Yes')</option>

                        </select>
                    </div>
                </div><!--form-group-->

            </x-slot>
            <x-slot name="footer">
                <button id="submitButton" class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Category')</button>
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



$(document).ready(function() {
    $("#parent_id").change(function() {
        var selectedValue = $(this).val();
        // console.log(selectedValue);
        var $divToHide1 = $('#hide1');
        var $divToHide2 = $('#hide2');
        var $divToHide3 = $('#hide3');
        var $divToHide4 = $('#hide4');
        
        // Clear input values
        $divToHide1.find('input').val('');
        $divToHide2.find('input').val('');
        $divToHide3.find('input').val('');
        $divToHide4.find('input').val('');


        
        if (selectedValue !== "0") {
            $divToHide1.hide();
            $divToHide2.hide();
            $divToHide3.hide();
            $divToHide4.hide();

        } else {
            $divToHide1.show();
            $divToHide2.show();
            $divToHide3.show();
            $divToHide4.show();

        }
    });
});
    </script>
@endpush
