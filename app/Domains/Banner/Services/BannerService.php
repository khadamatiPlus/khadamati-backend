<?php

namespace App\Domains\Banner\Services;
use App\Services\BaseService;
use App\Services\StorageManagerService;
use App\Exceptions\GeneralException;
use App\Domains\Banner\Models\Banner;

class BannerService extends BaseService
{

    /**
     * @var string $entityName
     */
    protected $entityName = 'Banner';


    /**
     * @var StorageManagerService $storageManagerService
     */
    protected $storageManagerService;

    /**
     * @param Banner $banner
     * @param StorageManagerService $storageManagerService
     */
    public function __construct(Banner $banner, StorageManagerService $storageManagerService)
    {
        $this->model = $banner;
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
        if(!empty($data['image']) && request()->hasFile('image')){
            try {
                $this->upload($data,'image');
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
//        echo json_encode($data['type']); exit();
        $banner = $this->getById($entity);

        if(!empty($data['image']) && request()->hasFile('image')){
            try {
                $this->storageManagerService->deletePublicFile($banner->image,'banner/images');

                $this->upload($data,'image','banner/images',$banner->image);

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
    private function upload(array &$data, $fileColumn, string $directory = 'banner/images',$old_file_name = null): array
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
