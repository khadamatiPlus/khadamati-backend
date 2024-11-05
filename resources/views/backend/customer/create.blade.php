@extends('backend.layouts.app')

@section('title', __('Create Customer'))

@section('content')
    <x-forms.post id="form" :action="route('admin.customer.store')" enctype="multipart/form-data">
        <x-backend.card>
            <x-slot name="header">
                @lang('Create Customer')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.customer.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">
                <div class="form-group row">
                    <label for="mobile_number" class="col-md-2 col-form-label">@lang('Mobile Number')</label>

                    <div class="col-md-10">
                        <input name="mobile_number" id="mobile_number" class="form-control" value="{{old('mobile_number')}}" required/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label">@lang('Name')</label>

                    <div class="col-md-10">
                        <input name="name" id="name" class="form-control" value="{{old('name')}}" required/>
                    </div>
                </div><!--form-group-->



                <div class="form-group row">
                    <label for="profile_pic" class="col-md-2 col-form-label">@lang('Profile Picture')</label>

                    <div class="col-md-10">
                        <input type="file" name="profile_pic" id="profile_pic" class="form-control" onchange="previewImage('profile_pic','blah_profile_pic')"/>
                        <img  class="mt-2 d-none" id="blah_profile_pic" height="100px" width="100px"  alt="{{old('profile_pic')}}"  />

                    </div>
                </div><!--form-group-->
            </x-slot>
            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Customer')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
@push('after-scripts')
    <script>
        $( document ).ready(function() {
            $('#is_instant_delivery').on('change', function(){
                this.value = this.checked ? 1 : 0;
            }).change();
        });

        // $('#form').submit(function() {
        //     debugger
        //     // Get the array of city IDs
        //     let cityIdsArray = $('#cityIds').val();
        //
        //     // Set the array of city IDs as the value of the hidden input field
        //     $('#cities').val(cityIdsArray);
        // });

        function previewImage(inputId, imageId) {
            var input = document.getElementById(inputId);
            var image = document.getElementById(imageId);
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    image.src = e.target.result;
                    image.classList.remove('d-none'); // Show the image
                }
                reader.readAsDataURL(input.files[0]); // Read the uploaded file as a data URL
            } else {
                image.src = '';
                image.classList.add('d-none'); // Hide the image if no file selected
            }
        }

        $('#mobile_number').keyup(function () {
            if (!this.value.match(/^(\d|-)+$/)) {
                this.value = this.value.replace(/[^0-9-+]/g, '');
            }
        });
        document.getElementById("selectAll").addEventListener("change", function() {
            var checkboxes = document.querySelectorAll("#cityIds option");
            checkboxes.forEach(function(checkbox) {
                checkbox.selected = event.target.checked;
            });

            var select = document.getElementById("cityIds");
            if (event.target.checked) {
                $('#sss').addClass('d-none');

            } else {
                $('#sss').removeClass('d-none');
            }
        });
    </script>
@endpush
