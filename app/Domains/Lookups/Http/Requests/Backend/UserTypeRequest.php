<?php
namespace App\Domains\Lookups\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\StorageManagerService;
use Illuminate\Http\Request;

class UserTypeRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @param Request $request
     * @return \string[][]
     */
    public function rules(Request $request): array
    {
        switch ($request->method()) {
            case self::METHOD_POST:
                return [
                    'name' => ['required', 'max:255'],
                    'name_ar' => ['required', 'max:255'],
                    'image' => ['nullable', 'mimes:'.implode(',',StorageManagerService::$allowedImages)],

                ];
            case self::METHOD_PATCH:
                return [
                    'id' => ['required', 'exists:user_types,id'],
                    'name' => ['required', 'max:255'],
                    'name_ar' => ['required', 'max:255'],
                    'image' => ['nullable', 'mimes:'.implode(',',StorageManagerService::$allowedImages)],

                ];
            case self::METHOD_DELETE:
            default:
                return [
                    'id' => ['required', 'exists:user_types,id']
                ];
        }
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
        ];
    }
}


