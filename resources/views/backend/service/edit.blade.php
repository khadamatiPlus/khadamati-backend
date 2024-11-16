@inject('model', '\App\Domains\Service\Models\Service')

@extends('backend.layouts.app')

@section('title', __('Update Service'))

@section('content')
    <x-forms.post :action="route('admin.service.update', $service)" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="PATCH" />
        <input type="hidden" name="id" value="{{$service->id}}" />

        <x-backend.card>
            <x-slot name="header">
                @lang('Update Service')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.service.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">
                <div class="row">
                    <div class="col-md-8">
                        <!-- Merchant Selection -->
                        <div class="form-group row">
                            <label for="merchant_id" class="col-md-2 col-form-label">@lang('Merchant')</label>
                            <div class="col-md-10">
                                <select name="merchant_id" id="merchant_id" class="form-control" required>
                                    <option value="" disabled>@lang('-- Select --')</option>
                                    @foreach ($merchants as $value)
                                        <option value="{{ $value->id }}" {{ $service->merchant_id == $value->id ? 'selected' : '' }}>
                                            {{ $value->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!--form-group-->

                        <!-- Category Selection -->
                        <div class="form-group mt-3 row">
                            <label class="col-md-2 col-form-label" for="sub_category_id">{{ __("Select Category:") }}</label>
                            <div class="col-md-10">
                                <select class="form-control" id="sub_category_id" name="sub_category_id">
                                    @foreach($categories as $category)
                                        <optgroup label="{{ $category->name }}">
                                            @foreach($category->children as $subCategory)
                                                <option value="{{ $subCategory->id }}"
                                                    {{ $subCategory->id == $service->sub_category_id ? 'selected' : '' }}>
                                                    - {{ $subCategory->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div><!--form-group-->

                        <!-- Title (EN) -->
                        <div class="form-group row">
                            <label for="title" class="col-md-2 col-form-label">@lang('Title')</label>
                            <div class="col-md-10">
                                <input type="text" value="{{ old('title', $service->title) }}" name="title" id="title" class="form-control" required />
                            </div>
                        </div><!--form-group-->

                        <!-- Description -->
                        <div class="form-group row">
                            <label for="description" class="col-md-2 col-form-label">@lang('Description')</label>
                            <div class="col-md-10">
                                <textarea name="description" id="description" class="form-control">{{ old('description', $service->description) }}</textarea>
                            </div>
                        </div><!--form-group-->

                        <!-- Price -->
                        <div class="form-group row">
                            <label for="price" class="col-md-2 col-form-label">@lang('Price')</label>
                            <div class="col-md-10">
                                <input type="number" value="{{ old('price', $service->price) }}" name="price" id="price" class="form-control" required />
                            </div>
                        </div><!--form-group-->

                        <!-- New Price -->
                        <div class="form-group row">
                            <label for="new_price" class="col-md-2 col-form-label">@lang('New Price')</label>
                            <div class="col-md-10">
                                <input type="number" value="{{ old('new_price', $service->new_price) }}" name="new_price" id="new_price" class="form-control" />
                            </div>
                        </div><!--form-group-->

                        <!-- Duration -->
                        <div class="form-group row">
                            <label for="duration" class="col-md-2 col-form-label">@lang('Duration')</label>
                            <div class="col-md-10">
                                <input type="text" value="{{ old('duration', $service->duration) }}" name="duration" id="duration" class="form-control" required />
                            </div>
                        </div><!--form-group-->

                        <!-- Order -->
                        <div class="form-group row">
                            <label for="order" class="col-md-2 col-form-label">@lang('Order')</label>
                            <div class="col-md-10">
                                <input type="number" value="{{ old('order', $service->order) }}" name="order" id="order" class="form-control" required />
                            </div>
                        </div><!--form-group-->

                        <!-- Tags Selection -->
                        <div class="form-group mt-3 row">
                            <label class="col-md-2 col-form-label" for="tags">{{ __("Select Tags:") }}</label>
                            <div class="col-md-10">
                                <select class="form-control" id="tags" name="tags[]" multiple>
                                    @foreach($tags as $tag)
                                        <optgroup label="{{ $tag->name }}">
                                            <option value="{{ $tag->id }}" {{ in_array($tag->id, $service->tags->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                {{ $tag->name }}
                                            </option>
                                            @foreach($tag->children as $subTag)
                                                <option value="{{ $subTag->id }}"
                                                    {{ in_array($subTag->id, $service->tags->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                    - {{ $subTag->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div><!--form-group-->

                        <!-- Image Upload -->
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" for="images">{{ __("Images:") }}</label>
                            <div class="col-md-10">
                                <input type="file" class="form-control" id="images" name="images[]" multiple>
                            </div>
                        </div><!--form-group-->
                        <div id="image-previews" class="form-group row"></div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">{{ __("Select Main Image:") }}</label>
                            <div id="main-image-selection">
                                <!-- Display existing main image if any -->
                                @if ($service->main_image)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="main_image" value="existing_image" checked>
                                        <label class="form-check-label" for="main_image_existing">
                                            Main Image (Existing)
                                        </label>
                                    </div>
                                @endif
                            </div>
                        </div><!--form-group-->
                    </div>

                    <!-- Products Section -->
                    <div class="col-md-4">
                        @foreach ($service->products as $index => $product)
                            <div class="product-item">
                                <input type="text" name="products[{{ $index }}][title]" value="{{ $product->title }}" class="form-control mb-2" placeholder="Title">
                                <input type="text" name="products[{{ $index }}][price]" value="{{ $product->price }}" class="form-control mb-2" placeholder="Price">
                                <input type="text" name="products[{{ $index }}][duration]" value="{{ $product->duration }}" class="form-control mb-2" placeholder="Duration">
                                <textarea name="products[{{ $index }}][description]" class="form-control mb-2" placeholder="Description">{{ $product->description }}</textarea>
                                <input type="text" name="products[{{ $index }}][order]" value="{{ $product->order }}" class="form-control mb-2" placeholder="Order">

                                <!-- Display existing image if available -->
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="img-thumbnail mt-2 row mx-2 w-50">
                                @endif

                                <!-- File input for uploading a new image -->
                                <input type="file" name="products[{{ $index }}][image]" class="form-control mb-2">

                                <!-- Add a delete button to remove the product (optional) -->
                                <button type="button" class="btn btn-danger mt-2" onclick="removeProduct(this)">Delete</button>
                            </div>
                        @endforeach

                        <div id="productsContainer">
                            <!-- Existing products will be displayed here if needed -->
                        </div>
                        <button type="button" class="btn btn-success" onclick="addProduct()">Add Product</button>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update Service')</button>
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

        function removeProduct(button) {
            // Remove the product item div when the delete button is clicked
            button.closest('.product-item').remove();
        }


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



    </script>
@endpush
