@extends('backend.layouts.app')
@section('title', __('Create Service'))
@section('content')
    <style>
        .product-item {
            margin-bottom: 15px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
    <x-forms.post :action="route('admin.service.store')" enctype="multipart/form-data">
        <x-backend.card>
            <x-slot name="header">
                @lang('Create Service')
            </x-slot>
            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.service.index')" :text="__('Cancel')" />
            </x-slot>
            <x-slot name="body">
                <div class="row">
                    <div class="col-md-8">
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

                        <div class="form-group mt-3 row">
                            <label class="col-md-2 col-form-label" for="sub_category_id">{{__("Select Category:")}}</label>
                            <div class="col-md-10">
                                <select class="form-control" id="sub_category_id" name="sub_category_id">
                                    @foreach($categories as $category)
                                        <optgroup label="{{ $category->name }}">
                                            @foreach($category->children as $subCategory)
                                                <option value="{{ $subCategory->id }}">- {{ $subCategory->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                <div class="form-group row">
                    <label for="title" class="col-md-2 col-form-label">@lang('Title')</label>
                    <div class="col-md-10">
                        <input type="text" value="{{old('title')}}" name="title" id="title" class="form-control" required />
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="description" class="col-md-2 col-form-label">@lang('Description')</label>
                    <div class="col-md-10">
                        <textarea name="description" id="description" class="form-control">{{old('description')}}</textarea>
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="price" class="col-md-2 col-form-label">@lang('Price')</label>
                    <div class="col-md-10">
                        <input type="number" value="{{old('price')}}" name="price" id="price" class="form-control" required />
                    </div>
                </div><!--form-group-->
                        <div class="form-group row">
                            <label for="new_price" class="col-md-2 col-form-label">@lang('New Price')</label>
                            <div class="col-md-10">
                                <input type="number" value="{{old('new_price')}}" name="new_price" id="new_price" class="form-control"  />
                            </div>
                        </div><!--form-group-->
                <div class="form-group row">
                    <label for="duration" class="col-md-2 col-form-label">@lang('duration')</label>
                    <div class="col-md-10">
                        <input type="text" value="{{old('duration')}}" name="duration" id="duration" class="form-control" required />
                    </div>
                </div><!--form-group-->
                <div class="form-group row">
                    <label for="order" class="col-md-2 col-form-label">@lang('Order')</label>
                    <div class="col-md-10">
                        <input type="number" value="{{old('order')}}" name="order" id="order" class="form-control" required />
                    </div>
                </div><!--form-group-->
                        <div class="form-group mt-3 row">
                            <label class="col-md-2 col-form-label" for="tags">{{__("Select Tags:")}}</label>
                            <div class="col-md-10">
                                <select class="form-control" id="tags" name="tags[]" multiple>
                                    @foreach($tags as $tag)
                                        <optgroup label="{{ $tag->name }}">
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                            @foreach($tag->children as $subTag)
                                                <option value="{{ $subTag->id }}">- {{ $subTag->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                            <!-- Image Upload -->
                            <div class="form-group row">
                                <label  class="col-md-2 col-form-label" for="images">{{__("Images:")}}</label>
                                <div class="col-md-10">
                                <input type="file" class="form-control" id="images" name="images[]" multiple required>
                                </div>
                            </div>
                            <div id="image-previews" class="form-group row " >
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">{{__("Select Main Image:")}}</label>
                                <div id="main-image-selection">
                                </div>
                            </div>

                    </div>
                        <div class="col-md-4">
                            <div id="productsContainer">
                                <!-- Products will be appended here -->
                            </div>
                            <button type="button" class="btn btn-success" onclick="addProduct()">Add Product</button>
                <!-- Tags Selection -->

                </div>
                </div>
            </x-slot>
            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Service')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
@push('after-scripts')
    <script>



        let productIndex = 0; // Keep track of the product index

        function addProduct() {
            // Create a container div for the input fields
            const productDiv = document.createElement("div");
            productDiv.classList.add("product-item");

            // Array of input field details
            const inputFields = [
                { name: `products[${productIndex}][title]`, placeholder: "Title", type: "text" },
                { name: `products[${productIndex}][price]`, placeholder: "Price", type: "text" },
                { name: `products[${productIndex}][duration]`, placeholder: "Duration", type: "text" },
                { name: `products[${productIndex}][description]`, placeholder: "Description", type: "textarea" },
                { name: `products[${productIndex}][order]`, placeholder: "Order", type: "text" },
                { name: `products[${productIndex}][image]`, placeholder: "Image", type: "file" }
            ];

            // Loop through the inputFields array to create each input element
            inputFields.forEach(field => {
                if (field.type === "textarea") {
                    // Create a textarea element for the description field
                    const textarea = document.createElement("textarea");
                    textarea.name = field.name;
                    textarea.placeholder = field.placeholder;
                    textarea.classList.add("form-control", "mb-2"); // Add Bootstrap classes for styling
                    productDiv.appendChild(textarea);
                } else if (field.type === "file") {
                    // Create an input element of type file for the image field
                    const fileInput = document.createElement("input");
                    fileInput.type = "file";
                    fileInput.name = field.name;
                    fileInput.classList.add("form-control", "mb-2"); // Add Bootstrap classes for styling

                    // Add an event listener to display the selected image
                    fileInput.addEventListener("change", function(event) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const imgPreview = document.createElement("img");
                                imgPreview.src = e.target.result;
                                imgPreview.alt = "Image Preview";
                                imgPreview.classList.add("img-thumbnail", "mt-2", "row", "mx-2", "w-50"); // Add Bootstrap classes for styling
                                productDiv.appendChild(imgPreview);
                            };
                            reader.readAsDataURL(file);
                        }
                    });

                    productDiv.appendChild(fileInput);
                } else {
                    // Create a regular input element for other fields
                    const input = document.createElement("input");
                    input.type = field.type;
                    input.name = field.name;
                    input.placeholder = field.placeholder;
                    input.classList.add("form-control", "mb-2"); // Add Bootstrap classes for styling
                    productDiv.appendChild(input);
                }
            });

            // Create a delete button
            const deleteButton = document.createElement("button");
            deleteButton.type = "button";
            deleteButton.textContent = "Delete";
            deleteButton.classList.add("btn", "btn-danger", "mt-2"); // Add Bootstrap classes for styling
            deleteButton.onclick = () => {
                productDiv.remove(); // Remove the productDiv when the delete button is clicked
            };
            productDiv.appendChild(deleteButton);

            // Append the productDiv to the productsContainer
            document.getElementById("productsContainer").appendChild(productDiv);

            // Increment the index for the next product
            productIndex++;
        }






        document.addEventListener('DOMContentLoaded', function() {
            const imagesInput = document.getElementById('images');
            const previewContainer = document.getElementById('image-previews');
            const mainImageSelection = document.getElementById('main-image-selection');

            // Listen for changes on the file input
            imagesInput.addEventListener('change', function() {
                const files = this.files;

                // Clear previous previews and options
                previewContainer.innerHTML = '';
                mainImageSelection.innerHTML = '';

                // Ensure files are selected
                if (files.length > 0) {
                    // Loop through the files and create image preview elements
                    for (let i = 0; i < files.length; i++) {
                        let file = files[i];

                        // Create an image element for preview
                        let img = document.createElement('img');
                        img.src = URL.createObjectURL(file); // Create object URL for the selected file
                        img.alt = 'Image ' + (i + 1);
                        img.style.width = '100px';  // Set width for the image preview
                        img.style.margin = '10px';  // Set margin for the image previews
                        img.classList.add('image-preview');  // Optional: Add a class for styling

                        // Append the preview image to the container
                        previewContainer.appendChild(img);

                        // Create a radio button to select this image as the main image
                        let radioContainer = document.createElement('div');
                        radioContainer.style.marginBottom = '10px';

                        let radio = document.createElement('input');
                        radio.type = 'radio';
                        radio.name = 'main_image';
                        radio.value = i;
                        radio.id = 'main_image_' + i;

                        let label = document.createElement('label');
                        label.setAttribute('for', 'main_image_' + i);
                        label.textContent = 'Main Image ' + (i + 1);

                        radioContainer.appendChild(radio);
                        radioContainer.appendChild(label);
                        mainImageSelection.appendChild(radioContainer);
                    }
                }
            });
        });
    </script>
@endpush
