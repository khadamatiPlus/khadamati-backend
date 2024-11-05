<?php

namespace App\Domains\Service\Services;
use App\Domains\Service\Models\Service;
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
        if(!empty($data['video']) && request()->hasFile('video')){
            try {
                $this->upload($data,'video');
            } catch (\Exception $e) {
                throw $e;
            }
        }

        return parent::store($data);
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
