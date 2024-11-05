<?php
namespace App\Domains\Social\Http\Controllers\Backend;
use App\Domains\Social\Http\Requests\Backend\SocialRequest;
use App\Domains\Social\Models\Social;
use App\Domains\Social\Services\SocialService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    private SocialService $socialService;

    /**
     * @param SocialService $socialService
     */
    public function __construct(SocialService $socialService)
    {
        $this->socialService = $socialService;
    }

    /**
     * @param Social $social
     * @return mixed
     */
    public function edit(Social $social)
    {
        return view('backend.social.social')
            ->withSocial($social);
    }

    /**
     * @param SocialRequest $request
     * @param $social
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(SocialRequest $request, $social)
    {
        $this->socialService->update($social, $request->validated());

        return redirect()->back()->withFlashSuccess(__('The Social was successfully updated'));
    }

}
