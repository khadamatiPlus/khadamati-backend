<?php

namespace App\Domains\Lookups\Http\Controllers\Backend;

use App\Domains\Lookups\Http\Requests\Backend\TagRequest;
use App\Domains\Lookups\Models\Tag;
use App\Domains\Lookups\Services\TagService;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    private TagService $tagService;

    /**
     * @param TagService $tagService
     */
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('backend.lookups.tag.index');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $tags = Tag::whereNull('parent_id')->get();
        return view('backend.lookups.tag.create',compact('tags'));
    }

    /**
     * @param TagRequest $request
     * @return mixed
     */
    public function store(TagRequest $request)
    {
        $this->tagService->store($request->validated());

        return redirect()->route('admin.lookups.tag.index')->withFlashSuccess(__('The Tag was successfully added'));
    }

    /**
     * @param Tag $tag
     * @return mixed
     */
    public function edit(Tag $tag)
    {
        $tags = Tag::whereNull('parent_id')->get();
        return view('backend.lookups.tag.edit',compact('tags'))
            ->withTag($tag);
    }

    /**
     * @param TagRequest $request
     * @param $tag
     * @return mixed
     */
    public function update(TagRequest $request, $tag)
    {
        $this->tagService->update($tag, $request->validated());

        return redirect()->back()->withFlashSuccess(__('The Tag was successfully updated'));
    }

    /**
     * @param $vehicleType
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function destroy($tag)
    {
        $this->tagService->destroy($tag);
        return redirect()->back()->withFlashSuccess(__('The Tag was successfully deleted.'));
    }
}
