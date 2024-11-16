@extends('backend.layouts.app')
@section('title', __('Create Merchant'))
@section('content')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCnERgO2sxll_9-hB4IqA5iIz-EARxpQ1M"></script>


    <x-forms.post :action="route('admin.merchant.store')" enctype="multipart/form-data">
        <x-backend.card>
            <x-slot name="header">
                @lang('Create Merchant')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.merchant.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">

                <div class="form-group row">
                    <label for="mobile_number" class="col-md-2 col-form-label">@lang('Mobile Number')</label>
                    <div class="col-md-10">
                        <input placeholder="{{ __('Mobile Number') }}" name="mobile_number" id="mobile_number" class="form-control"  value="{{old('mobile_number')}}" required/>
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="email" class="col-md-2 col-form-label">@lang('E-mail Address')</label>
                    <div class="col-md-10">
                        <input type="email" name="email" class="form-control" placeholder="{{ __('E-mail Address') }}" value="{{ old('email') }}" maxlength="255" required />
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="password" class="col-md-2 col-form-label">@lang('Password')</label>

                    <div class="col-md-10">
                        <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password') }}" maxlength="100" required autocomplete="new-password" />
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="password_confirmation" class="col-md-2 col-form-label">@lang('Password Confirmation')</label>

                    <div class="col-md-10">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Password Confirmation') }}" maxlength="100" required autocomplete="new-password" />
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label">@lang('Name')</label>

                    <div class="col-md-10">
                        <input placeholder="{{ __('Name') }}" name="name" id="name" value="{{old('name')}}" class="form-control" required/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="profile_pic" class="col-md-2 col-form-label">@lang('Image')</label>
                    <div class="col-md-10">
                        <input placeholder="{{ __('Image') }}" onchange="readURL(this)" type="file" name="profile_pic" id="profile_pic" class="form-control"  accept="image/*" />
                        <img  class="mt-2 d-none" id="profile_pic_blah" height="100px" width="100px"  alt="{{old('profile_pic')}}" />
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
                    <label for="city_id" class="col-md-2 col-form-label">@lang('City')</label>
                    <div class="col-md-10">
                        <select name="city_id" id="city_id" class="form-control" >
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="area_id" class="col-md-2 col-form-label">@lang('Area')</label>
                    <div class="col-md-10">
                        <select name="area_id" id="area_id" class="form-control" >
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                <!-- Button to Open the Modal -->
                    <label for="area_id" class="col-md-2 col-form-label">@lang('Location')</label>
                    <div class="col-md-10">
                <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#mapModal">
                    {{__("Select Location")}}
                </button>
                    </div>
                </div>
                <!-- Modal Structure -->
                <div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mapModalLabel">Select Location on Map</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="map" style="height: 400px;"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="latitude" class="col-md-2 col-form-label">@lang('Latitude')</label>
                    <div class="col-md-10">
                        <input placeholder="{{ __('Latitude') }}" name="latitude" id="latitude" value="{{old('latitude')}}" class="form-control" required step="any" min="-90" max="90"/>
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="longitude" class="col-md-2 col-form-label">@lang('Longitude')</label>
                    <div class="col-md-10">
                        <input placeholder="{{ __('Longitude') }}" name="longitude" id="longitude" value="{{old('longitude')}}" class="form-control" required step="any" min="-180" max="180"/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="is_verified" class="col-md-2 col-form-label">@lang('Is Verified')</label>

                    <div class="col-md-1">
                        <input type="checkbox"  {{old('is_verified')==1?'checked':""}}  name="is_verified" id="is_verified" value="0" />
                    </div>
                </div><!--form-group-->

            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Merchant')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
@push('after-scripts')
    <script>
        $(document).ready(function() {
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#profile_pic_blah').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#profile_pic").change(function(){
                $('#profile_pic_blah').removeClass('d-none');
                readURL(this);
            });

            $('select[name="country_id"]').on('change', function() {
                var CountryId = $(this).val();
                if (CountryId) {
                    $.ajax({
                        url: "{{ URL::to('admin/merchant/getCities')}}/" + CountryId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var citySelect = $('select[name="city_id"]');
                            citySelect.empty();

                            // Populate city options
                            $.each(data, function(key, value) {
                                citySelect.append('<option value="' + key + '">' + value + '</option>');
                            });

                            // Automatically trigger change event for the first city
                            if (citySelect.children('option').length > 0) {
                                citySelect.val(citySelect.children('option').first().val()).change();
                            }
                        },
                    });
                } else {
                    console.log('ajax work did not work');
                }
            });

            $('select[name="city_id"]').on('change', function() {
                var cityId = $(this).val();
                if (cityId) {
                    $.ajax({
                        url: "{{ URL::to('admin/merchant/getAreas')}}/" + cityId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var areaSelect = $('select[name="area_id"]');
                            areaSelect.empty();

                            // Populate area options
                            $.each(data, function(key, value) {
                                areaSelect.append('<option value="' + key + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    console.log('ajax work did not work');
                }
            });
        });

        // Function to initialize the map
        function initMap() {
            // Set the default location to Amman, Jordan
            var defaultLocation = { lat: 31.963158, lng: 35.930359 };

            // Create the map centered on Amman
            var map = new google.maps.Map(document.getElementById('map'), {
                center: defaultLocation,
                zoom: 10
            });

            // Create a marker at the default location
            var marker = new google.maps.Marker({
                position: defaultLocation,
                map: map,
                draggable: true // Allow the marker to be dragged
            });

            // Update input fields with default location
            document.getElementById('latitude').value = defaultLocation.lat;
            document.getElementById('longitude').value = defaultLocation.lng;

            // Event listener to update input fields when the marker is dragged
            marker.addListener('dragend', function(event) {
                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();
            });

            // Event listener to update the marker position and input fields when the map is clicked
            map.addListener('click', function(event) {
                marker.setPosition(event.latLng);
                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();
            });
        }

        // Initialize the map
        google.maps.event.addDomListener(window, 'load', initMap);
    </script>
@endpush
