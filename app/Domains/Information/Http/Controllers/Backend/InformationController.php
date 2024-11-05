<?php
namespace App\Domains\Information\Http\Controllers\Backend;
use App\Domains\Information\Http\Requests\Backend\InformationRequest;
use App\Domains\Information\Models\Information;
use App\Domains\Information\Services\InformationService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    private InformationService $informationService;

    /**
     * @param InformationService $informationService
     */
    public function __construct(InformationService $informationService)
    {
        $this->informationService = $informationService;
    }

    /**
     * @param Information $information
     * @return mixed
     */
    public function edit(Information $information)
    {
        return view('backend.information.edit')
            ->withInformation($information);
    }

    /**
     * @param InformationRequest $request
     * @param $setting
     * @return mixed
     */
    public function update(InformationRequest $request, $information)
    {
        $this->informationService->update($information, $request->validated());

        return redirect()->back()->withFlashSuccess(__('The Information was successfully updated'));
    }
}
