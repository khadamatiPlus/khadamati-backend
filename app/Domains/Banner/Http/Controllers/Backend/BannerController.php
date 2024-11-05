<?php
namespace App\Domains\Banner\Http\Controllers\Backend;
use App\Domains\Banner\Http\Requests\Backend\BannerRequest;
use App\Domains\Banner\Models\Banner;
use App\Domains\Banner\Services\BannerService;
use App\Domains\FirebaseIntegration\FirebaseIntegration;
use App\Domains\Notification\Http\Requests\Backend\NotificationRequest;
use App\Domains\Lookups\Services\CategoryService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
class BannerController extends Controller
{
    private BannerService $bannerService;


    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('backend.banner.index');
    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('backend.banner.create');
    }

    /**
     * @param BannerRequest $request
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(BannerRequest $request)
    {
        $this->bannerService->store($request->validated());
        return redirect()->route('admin.banner.index')->withFlashSuccess(__('The Banner was successfully added'));
    }

    /**
     * @param Banner $banner
     * @return mixed
     */
    public function edit(Banner $banner)
    {
        return view('backend.banner.edit')
            ->withBanner($banner);
    }

    /**
     * @param BannerRequest $request
     * @param $banner
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(BannerRequest $request, $banner)
    {
        $this->bannerService->update($banner, $request->validated());
        return redirect()->back()->withFlashSuccess(__('The Banner was successfully updated'));
    }
    /**
     * @param $notification
     * @return mixed
     */
    public function destroy($banner)
    {
        $this->bannerService->destroy($banner);
        return redirect()->back()->withFlashSuccess(__('The Banner was successfully deleted.'));
    }

}
