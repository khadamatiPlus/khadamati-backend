<?php

namespace App\Domains\Lookups\Http\Controllers\Backend;

use App\Domains\Lookups\Http\Requests\Backend\PageRequest;
use App\Domains\Lookups\Models\Page;
use App\Domains\Lookups\Services\PageService;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    private PageService $pageService;

    /**
     * @param PageService $pageService
     */
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('backend.lookups.page.index');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('backend.lookups.page.create');
    }

    /**
     * @param PageRequest $request
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(PageRequest $request)
    {
        $this->pageService->store($request->validated());

        return redirect()->route('admin.lookups.page.index')->withFlashSuccess(__('The Page was successfully added'));
    }

    /**
     * @param Page $page
     * @return mixed
     */
    public function edit(Page $page)
    {
        return view('backend.lookups.page.edit')
            ->withPage($page);
    }

    /**
     * @param PageRequest $request
     * @param $page
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(PageRequest $request, $page)
    {
        $this->pageService->update($page, $request->validated());

        return redirect()->back()->withFlashSuccess(__('The Page was successfully updated'));
    }

    /**
     * @param $page
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function destroy($page)
    {
        $this->pageService->destroy($page);
        return redirect()->back()->withFlashSuccess(__('The Page was successfully deleted.'));
    }
}
