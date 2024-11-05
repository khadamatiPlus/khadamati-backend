<?php
namespace App\Domains\Lookups\Http\Controllers\Backend;
use App\Domains\Lookups\Http\Requests\Backend\CategoryRequest;
use App\Domains\Lookups\Services\CategoryService;
use App\Domains\Lookups\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class CategoryController extends Controller
{
    protected $modelType = Category::class;

    /**
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('backend.lookups.category.index');
    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $categories = $this->categoryService->where('parent_id',null)->select(['id','name'])->get();
        return view('backend.lookups.category.create')
            ->withCategories($categories);
    }
    /**
     * @param CategoryRequest $request
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(CategoryRequest $request)
    {
        $this->categoryService->store($request->validated());
        return redirect()->route('admin.lookups.category.index')->withFlashSuccess(__('The Category was successfully added'));
    }
    /**
     * @param Category $category
     * @return mixed
     */
    public function edit(Category $category)
    {
        $categories = $this->categoryService->select(['id','name'])->get();
        return view('backend.lookups.category.edit')
            ->withCategory($category)
            ->withCategories($categories);
    }

    /**
     * @param CategoryRequest $request
     * @param $category
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(CategoryRequest $request, $category)
    {
        $this->categoryService->update($category, $request->validated());
        return redirect()->back()->withFlashSuccess(__('The Category was successfully updated'));
    }
    /**
     * @param $category
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function destroy($category)
    {
        $this->categoryService->destroy($category);
        return redirect()->back()->withFlashSuccess(__('The Category was successfully deleted.'));
    }
}
