<?php
namespace App\Domains\Lookups\Services;
use App\Services\BaseService;
use App\Services\StorageManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Domains\Lookups\Models\Category;
class CategoryService extends BaseService
{
    /**
     * @var string $entityName
     */
    protected $entityName = 'Category';
    /**
     * @var StorageManagerService $storageManagerService
     */
    protected $storageManagerService;
    /**
     * @param Category $category
     * @param StorageManagerService $storageManagerService
     */
    public function __construct(Category $category, StorageManagerService $storageManagerService)
    {
        $this->model = $category;
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
        if($data['is_featured']==1){
            $data['is_featured']=true;
        }
        if($data['parent_id']==0){
            $data['parent_id']=null;
        }
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
        $category = $this->getById($entity);
        if(!isset($data['parent_id'])){
            $data['parent_id']=null;
        }
//        if($data['is_featured']==1){
//            $data['is_featured']=true;
//        }
        if(!isset($data['is_featured'])){
            $data['is_featured']=false;
        }
        if(!empty($data['image']) && request()->hasFile('image')){
            try {
                $this->storageManagerService->deletePublicFile($category->image,'category/images');

                $this->upload($data,'image','category/images',$category->image);

            } catch (\Exception $e) {
                throw $e;
            }
        }
        if(isset($data['parent_id'])){
            $category->update([
                'is_parent' => 0,
            ]);
        }
        if(!isset($data['is_parent'])){
            $data['is_parent'] =0;
            $category->update([
                'is_parent' => 0,
            ]);
        }

    else{
            $data['is_parent'] = 1;
        $category->update([
            'parent_id' => null,
        ]);
        }
//        echo json_encode($data['is_parent']);exit();

        return parent::update($entity, $data);
    }
    /**
     * @param array $data
     * @param $fileColumn
     * @param string $directory
     * @return array
     * @throws \Exception
     */
    private function upload(array &$data, $fileColumn, string $directory = 'category/images',$old_file_name = null): array
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
