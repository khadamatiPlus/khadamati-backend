<?php

namespace App\Domains\Lookups\Http\Controllers\Backend;

use App\Domains\Lookups\Http\Requests\Backend\UserTypeRequest;
use App\Domains\Lookups\Models\UserType;
use App\Domains\Lookups\Services\UserTypeService;
use App\Http\Controllers\Controller;

class UserTypeController extends Controller
{
    private UserTypeService $userTypeService;

    /**
     * @param UserTypeService $userTypeService
     */
    public function __construct(UserTypeService $userTypeService)
    {
        $this->userTypeService = $userTypeService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('backend.lookups.user-type.index');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('backend.lookups.user-type.create');
    }

    /**
     * @param UserTypeRequest $request
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(UserTypeRequest $request)
    {
        $this->userTypeService->store($request->validated());

        return redirect()->route('admin.lookups.userType.index')->withFlashSuccess(__('The User Type was successfully added'));
    }

    /**
     * @param UserType $userType
     * @return mixed
     */
    public function edit(UserType $userType)
    {
        return view('backend.lookups.user-type.edit')
            ->withUserType($userType);
    }

    /**
     * @param UserTypeRequest $request
     * @param $userType
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(UserTypeRequest $request, $userType)
    {
        $this->userTypeService->update($userType, $request->validated());

        return redirect()->back()->withFlashSuccess(__('The User Type was successfully updated'));
    }

    /**
     * @param $userType
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function destroy($userType)
    {
        $this->userTypeService->destroy($userType);
        return redirect()->back()->withFlashSuccess(__('The User Type was successfully deleted.'));
    }
}
