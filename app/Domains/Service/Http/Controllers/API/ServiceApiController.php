<?php

namespace App\Domains\Service\Http\Controllers\API;

use App\Domains\Lookups\Models\Category;
use App\Domains\Merchant\Http\Transformers\MerchantTransformer;
use App\Domains\Service\Http\Transformers\ServiceTransformer;
use App\Domains\Service\Models\Service;
use App\Domains\Service\Models\ServiceProduct;
use App\Domains\Service\Services\ServiceService;
use App\Http\Controllers\APIBaseController;
use Illuminate\Http\Request;

class ServiceApiController extends APIBaseController
{

    private ServiceService $serviceService;


    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    public function storeService(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
//            'merchant_id' => 'required|exists:merchants,id',
            'sub_category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'new_price' => 'nullable|numeric',
            'duration' => 'required|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'images' => 'nullable|array',
            'images.*.image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*.is_main' => 'required|boolean', // Validate the 'is_main' flag
            'products' => 'nullable|array',
            'products.*.title' => 'required|string',
            'products.*.price' => 'required|numeric',
            'products.*.description' => 'nullable|string',
            'products.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category=Category::query()->where('id',$validated['sub_category_id'])->first();
        $service = Service::create([
            'merchant_id' => auth()->user()->merchant_id,
            'sub_category_id' => $validated['sub_category_id'],
            'category_id' => $category->parent_id,
            'title' => $validated['title'],
            'title_ar' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'new_price' => $validated['new_price']??null,
            'duration' => $validated['duration'],
        ]);

        // Attach tags if any
        if (isset($validated['tags'])) {
            $service->tags()->sync($validated['tags']);
        }

        // Handle image uploads and 'is_main' flag
        if ($request->has('images')) {
            $images = [];
            foreach ($validated['images'] as $imageData) {
                $imagePath = $imageData['image']->store('services', 'public'); // Store image file
                $images[] = [
                    'image' => $imagePath,
                    'is_main' => $imageData['is_main'], // Store 'is_main' flag
                ];
            }

            // Store images in the service's image relationship
            $service->images()->createMany($images);
        }

        // Handle products if any
        if (isset($validated['products'])) {
            foreach ($validated['products'] as $productData) {
                $product = ServiceProduct::create([
                    'service_id' => $service->id,
                    'title' => $productData['title'],
                    'price' => $productData['price'],
                    'description' => $productData['description'],
                    'order' => $productData['order']??null,
                ]);

                // Handle product image
                if (isset($productData['image'])) {
                    $productImagePath = $productData['image']->store('products', 'public');
                    $product->update(['image' => $productImagePath]);
                }
            }
        }
        return $this->successResponse(
            (new ServiceTransformer)->transform($service)
        );
    }


    public function updateService(Request $request, $id)
    {
        // Validate incoming request
        $validated = $request->validate([
//            'merchant_id' => 'nullable|exists:merchants,id',
            'sub_category_id' => 'nullable|exists:categories,id',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'new_price' => 'nullable|numeric',
            'duration' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'images' => 'nullable|array',
            'images.*.image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*.is_main' => 'nullable|boolean', // Validate the 'is_main' flag
            'products' => 'nullable|array',
            'products.*.title' => 'nullable|string',
            'products.*.price' => 'nullable|numeric',
            'products.*.description' => 'nullable|string',
            'products.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the existing service by ID
        $service = Service::findOrFail($id);

        // Update the service details if they are provided
        $service->update([
            'merchant_id' => auth()->user()->merchant_id,
            'sub_category_id' => $validated['sub_category_id'] ?? $service->sub_category_id,
            'category_id' => Category::find($validated['sub_category_id'])->parent_id ?? $service->category_id,
            'title' => $validated['title'] ?? $service->title,
            'title_ar' => $validated['title_ar'] ?? $service->title_ar,
            'description' => $validated['description'] ?? $service->description,
            'price' => $validated['price'] ?? $service->price,
            'new_price' => $validated['new_price'] ?? $service->new_price,
            'duration' => $validated['duration'] ?? $service->duration,
        ]);

        // Attach or update tags if any
        if (isset($validated['tags'])) {
            $service->tags()->sync($validated['tags']);
        }

        // Handle image uploads and update 'is_main' flag
        if ($request->has('images')) {
            // Delete existing images (if needed, depending on your use case)
            $service->images()->delete();

            $images = [];
            foreach ($validated['images'] as $imageData) {
                $imagePath = $imageData['image']->store('services', 'public'); // Store image file
                $images[] = [
                    'image' => $imagePath,
                    'is_main' => $imageData['is_main'], // Store 'is_main' flag
                ];
            }

            // Store new images in the service's image relationship
            $service->images()->createMany($images);
        }

        // Handle updating products if any
        if (isset($validated['products'])) {
            foreach ($validated['products'] as $productData) {
                $product = ServiceProduct::updateOrCreate(
                    ['id' => $productData['id'], 'service_id' => $service->id], // Find or create by product ID
                    [
                        'title' => $productData['title'],
                        'price' => $productData['price'],
                        'description' => $productData['description'],
                        'order' => $productData['order'] ?? null,
                    ]
                );

                // Handle product image upload if present
                if (isset($productData['image'])) {
                    $productImagePath = $productData['image']->store('products', 'public');
                    $product->update(['image' => $productImagePath]);
                }
            }
        }

        return $this->successResponse(
            (new ServiceTransformer)->transform($service)
        );
    }

    public function getServiceDetails($id)
    {
        // Find the service by ID
        $service = Service::with(['tags', 'images', 'products'])->find($id);

        // Check if service exists
        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        // Return the service details using the transformer
        return $this->successResponse(
            (new ServiceTransformer)->transform($service)
        );
    }

    public function getServices(Request $request)
    {
        // Get the authenticated merchant_id
        $merchant_id = auth()->user()->merchant_id;

        // Base query to get services for the authenticated merchant
        $query = Service::query()->where('merchant_id', $merchant_id);

        // Apply optional search filters if provided
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply pagination
        $services = $query->paginate(10); // Adjust the items per page as needed

        // Transform the paginated data
        $transformedServices = $services->getCollection()->map(function ($service) {
            return (new ServiceTransformer)->transform($service);
        });

        // Return the response using successResponse
        return $this->successResponse([
            'data' => $transformedServices,
            'pagination' => [
                'total' => $services->total(),
                'count' => $services->count(),
                'per_page' => $services->perPage(),
                'current_page' => $services->currentPage(),
                'total_pages' => $services->lastPage(),
            ],
        ]);
    }

}
