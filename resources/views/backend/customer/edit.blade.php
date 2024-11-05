@inject('model', '\App\Domains\Customer\Models\Customer')

@extends('backend.layouts.app')

@section('title', __('Update Customer'))

@section('content')
    <x-forms.post id="form" :action="route('admin.customer.update', $customer)"  enctype="multipart/form-data" id="form">
        <input type="hidden" name="_method" value="PATCH" />
        <x-backend.card>
            <x-slot name="header">
                @lang('Update Captain')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.customer.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">

                <input type="hidden" name="id" value="{{$customer->id}}" />



                <div class="form-group row">
                    <label for="first_name" class="col-md-2 col-form-label">@lang('Name')</label>

                    <div class="col-md-10">
                        <input name="name" id="name" class="form-control" value="{{ old('name') ?? $customer->name }}" required/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="profile_pic" class="col-md-2 col-form-label">@lang('Profile Picture')</label>

                    <div class="col-md-10">
                        <input type="file" name="profile_pic" id="profile_pic" class="form-control" onchange="previewImage('profile_pic','blah_profile_pic')"/>

                        <img  class="@if(!isset($customer->profile_pic)) d-none @endif mt-2" id="blah_profile_pic" src="{{storageBaseLink(\App\Enums\Core\StoragePaths::CAPTAIN_PROFILE_PIC.$customer->profile_pic)}}" height="100px" width="100px"  alt="{{old('profile_pic')}}"  />

                    </div>
                </div><!--form-group-->

            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update Customer')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection

@push('after-scripts')
    <script>
        $(document).ready(function() {
            $('#is_verified').on('change', function(){
                this.value = this.checked ? 'yes' : 'no';
            }).change();

            $('#is_instant_delivery').on('change', function(){
                debugger
                this.value = this.checked ? 'yes' : 'no';
            }).change();

        });
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
        $('#form').submit(function() {
            debugger
            // event.preventDefault();
            let cityIdsString = JSON.stringify($('#cityIds').val());
            $('#cities').val(cityIdsString);
            let sdsfwfe = $('#cities').val();
        });
    </script>

@endpush
