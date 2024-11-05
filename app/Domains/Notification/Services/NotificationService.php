<?php

namespace App\Domains\Notification\Services;
use App\Services\BaseService;
use App\Services\StorageManagerService;
use App\Exceptions\GeneralException;
use App\Domains\Notification\Models\Notification;

class NotificationService extends BaseService
{

    /**
     * @var string $entityName
     */
    protected $entityName = 'Notification';


    /**
     * @var StorageManagerService $storageManagerService
     */
    protected $storageManagerService;

    /**
     * @param Notification $notification
     * @param StorageManagerService $storageManagerService
     */
    public function __construct(Notification $notification, StorageManagerService $storageManagerService)
    {
        $this->model = $notification;
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
        if(!empty($data['notification_icon']) && request()->hasFile('notification_icon')){
            try {
                $this->upload($data,'notification_icon');
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
        $notification = $this->getById($entity);

        if(!empty($data['notification_icon']) && request()->hasFile('notification_icon')){
            try {
                $this->storageManagerService->deletePublicFile($notification->notification_icon,'notification/notification_icons');

                $this->upload($data,'notification_icon','notification/notification_icons',$notification->notification_icon);

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
    private function upload(array &$data, $fileColumn, string $directory = 'notification/notification_icons',$old_file_name = null): array
    {
        try{
            $data[$fileColumn] = $this->storageManagerService->uploadPublicFile($data[$fileColumn],$directory,$old_file_name);
            return $data;
        }
        catch (\Exception $exception){
            throw $exception;
        }
    }
    /**
     * @return \Illuminate\Database\Eloquent\Builder|mixed
     */
    public function applyQueryFilters()
    {
        if(auth()->user()->merchant){
            return $this->model::query()
                ->where(function ($q){
                    $q->where('is_sent','=','1')->where('type','merchant')
                    ;
                })
                ;
        }
        if(auth()->user()->captain){
            return $this->model::query()
                ->where(function ($q){
                    $q->where('is_sent','=','1')->where('type','captain')
                    ;
                })
                ;
        }
    }
}
