<?php

namespace App\Domains\Lookups\Services;

use App\Domains\Lookups\Models\UserType;
use App\Services\BaseService;
use App\Services\StorageManagerService;

/**
 * Class UserTypeService
 */
class UserTypeService extends BaseService
{

    /**
     * @var $entityName
     */
    protected $entityName = 'UserType';

    /**
     * @param UserType $userType
     */
    public function __construct(UserType $userType,StorageManagerService $storageManagerService)
    {
        $this->model = $userType;
        $this->storageManagerService = $storageManagerService;
    }

    public function store(array $data = [])
    {

        if (!empty($data['image']) && request()->hasFile('image')) {
            try {
                $this->upload($data, 'image');
            } catch (\Exception $e) {
                throw $e;
            }
        }
        return parent::store($data);
    }

    public function update($entity, array $data = [])
    {
        $data = array_filter($data);
        $userType = $this->getById($entity);

        if (!empty($data['image']) && request()->hasFile('image')) {
            try {
                $this->storageManagerService->deletePublicFile($userType->image, 'usertype/images');
                $data = $this->upload($data, 'image', 'usertype/images');
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
    private function upload(array &$data, $fileColumn, string $directory = 'usertype/images'): array
    {
        try{
            $data[$fileColumn] = $this->storageManagerService->uploadPublicFile($data[$fileColumn],$directory);
            return $data;
        }
        catch (\Exception $exception){
            throw $exception;
        }
    }
}
