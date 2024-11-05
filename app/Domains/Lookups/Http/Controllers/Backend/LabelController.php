<?php

namespace App\Domains\Lookups\Http\Controllers\Backend;

use App\Domains\Lookups\Http\Requests\Backend\LabelRequest;
use App\Domains\Lookups\Models\Label;
use App\Domains\Lookups\Services\LabelService;
use App\Http\Controllers\Controller;

class LabelController extends Controller
{
    private LabelService $labelService;

    public function __construct(LabelService $labelService)
    {
        $this->labelService = $labelService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('backend.lookups.label.index');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('backend.lookups.label.create');
    }


    public function store(LabelRequest $request)
    {
        $this->labelService->store($request->validated());

        return redirect()->route('admin.lookups.label.index')->withFlashSuccess(__('The Label was successfully added'));
    }


    public function edit(Label $label)
    {
        return view('backend.lookups.label.edit')
            ->withLabel($label);
    }


    public function update(LabelRequest $request, $label)
    {
        $this->labelService->update($label, $request->validated());

        return redirect()->back()->withFlashSuccess(__('The Label was successfully updated'));
    }

    /**
     * @param $businessType
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function destroy($label)
    {
        $this->labelService->destroy($label);
        return redirect()->back()->withFlashSuccess(__('The Label was successfully deleted.'));
    }
}
