<?php
namespace App\Domains\Rating\Http\Controllers\Backend;
use App\Domains\Rating\Services\RatingService;
use App\Http\Controllers\Controller;

class RatingController extends Controller
{
    private RatingService $ratingService;

    /**
     * @param RatingService $ratingService
     */
    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;

    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('backend.rating.index');
    }
}
