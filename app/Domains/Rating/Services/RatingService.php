<?php

namespace App\Domains\Rating\Services;
use App\Domains\Rating\Models\Rating;
use App\Exceptions\GeneralException;
use App\Services\BaseService;
use Illuminate\Http\Request;



class RatingService extends BaseService
{

    /**
     * @var string $entityName
     */
    protected $entityName = 'Rating';

    protected $storageManagerService;


    /**
     * @param Rating $rating
     */
    public function __construct(Rating $rating)
    {
        $this->model = $rating;
    }


    /**
     * @param array $data
     * @return mixed
     * @throws GeneralException
     * @throws \Throwable
     */
    public function store(array $data = [])
    {
        $data['merchant_id']=auth()->user()->merchant_id;

        $rating = parent::store($data);

        return $rating;
    }

}
