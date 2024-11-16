<?php
namespace App\Domains\Introduction\Http\Controllers\Backend;
use App\Domains\Introduction\Http\Requests\Backend\IntroductionRequest;
use App\Domains\Introduction\Models\Introduction;
use App\Domains\Introduction\Services\IntroductionService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
class IntroductionController extends Controller
{
    private IntroductionService $introductionService;


    public function __construct(IntroductionService $introductionService)
    {
        $this->introductionService = $introductionService;
    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('backend.introduction.index');
    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('backend.introduction.create');
    }

    public function store(IntroductionRequest $request)
    {
        $this->introductionService->store($request->validated());
        return redirect()->route('admin.introduction.index')->withFlashSuccess(__('The Introduction was successfully added'));
    }


    public function edit(Introduction $introduction)
    {
        return view('backend.introduction.edit')
            ->withIntroduction($introduction);
    }


    public function update(IntroductionRequest $request, $introduction)
    {
        $this->introductionService->update($introduction, $request->validated());
        return redirect()->back()->withFlashSuccess(__('The Introduction was successfully updated'));
    }

    public function destroy($introduction)
    {
        $this->introductionService->destroy($introduction);
        return redirect()->back()->withFlashSuccess(__('The Introduction was successfully deleted.'));
    }

}
