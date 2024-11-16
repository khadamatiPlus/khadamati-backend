<?php

namespace App\Domains\Service\Services;
use App\Domains\Lookups\Models\Category;
use App\Domains\Service\Models\Service;
use App\Domains\Service\Models\ServiceImage;
use App\Domains\Service\Models\ServiceProduct;
use App\Services\BaseService;
use App\Services\StorageManagerService;
use App\Exceptions\GeneralException;
use App\Domains\Notification\Models\Notification;

class ServiceService extends BaseService
{

    /**
     * @var string $entityName
     */
    protected $entityName = 'Service';


    /**
     * @var StorageManagerService $storageManagerService
     */
    protected $storageManagerService;

    /**
     * @param Service $service
     * @param StorageManagerService $storageManagerService
     */
    public function __construct(Service $service, StorageManagerService $storageManagerService)
    {
        $this->model = $service;
        $this->storageManagerService = $storageManagerService;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws GeneralException
     * @throws \Throwable
     */
    public function store(array $data = [])
    {
        if(!empty($data['main_image']) && request()->hasFile('main_image')){
            try {
                $this->upload($data,'main_image');
            } catch (\Exception $e) {
                throw $e;
            }
        }
        $data['title_ar']=$data['title'];
        if(!empty($data['video']) && request()->hasFile('video')){
            try {
                $this->upload($data,'video');
            } catch (\Exception $e) {
                throw $e;
            }
        }
//        echo $data['sub_category_id'];exit();
        $category=Category::query()->where('id',$data['sub_category_id'])->first();

        $data['category_id']=$category->parent_id;
        $service= parent::store($data);
        $service->tags()->attach($data['tags']);

        $images = request()->file('images');
        $mainImageIndex = request()->input('main_image');

        foreach ($images as $index => $image) {
            // Store the image and get the file path
            $filePath = $image->store('service_images', 'public');
//            echo $filePath;exit();

            // Create a new ServiceImage instance and save to database
            ServiceImage::create([
                'image' => $filePath,
                'service_id' =>$service->id, // Make sure to get the service ID
                'is_main' => $index == $mainImageIndex ? 1 : 0, // Set is_main based on the selected main image
            ]);
        }

        // Handle product details
        if (!empty($data['products'])) {
            foreach ($data['products'] as $index => $productData) {

                if (isset($productData['image']) && request()->hasFile("products.{$index}.image")) {

                    $imageFile = request()->file("products.{$index}.image");
                    $productImagePath = $imageFile->store('product_images', 'public');

                } else {
                    $productImagePath = null; // Handle cases where no image is uploaded
                }

                ServiceProduct::create([
                    'service_id' => $service->id,
                    'title' => $productData['title'],
                    'price' => $productData['price'],
                    'duration' => $productData['duration'],
                    'description' => $productData['description'],
                    'order' => $productData['order'],
                    'image' => $productImagePath,
                ]);
            }
        }

        return $service ;
    }

    /**
     * @param $entity
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     * @throws GeneralException
     * @throws \Throwable
     */
    public function update($entity, array $data = [])
    {
        $data = array_filter($data);
        $service = $this->getById($entity);
        if(!empty($data['main_image']) && request()->hasFile('main_image')){
            try {
                $this->storageManagerService->deletePublicFile($service->main_image,'service/files');
                $this->upload($data,'main_image','service/files',$service->main_image);
            } catch (\Exception $e) {
                throw $e;
            }
        }
        if(!empty($data['video']) && request()->hasFile('video')){
            try {
                $this->storageManagerService->deletePublicFile($service->video,'service/files');
                $this->upload($data,'video','service/files',$service->video);
            } catch (\Exception $e) {
                throw $e;
            }
        }



        return parent::update($entity, $data);
    }

    /**
     * @param array $data
     * @param $fileColumn
     * @param string $directory
     * @return array
     * @throws \Exception
     */
    private function upload(array &$data, $fileColumn, string $directory = 'service/files',$old_file_name = null): array
    {
        try{
            $data[$fileColumn] = $this->storageManagerService->uploadPublicFile($data[$fileColumn],$directory,$old_file_name);
            return $data;
        }
        catch (\Exception $exception){
            throw $exception;
        }
    }
}
