<?php
namespace App\Domains\Lookups\Http\Requests\Backend;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\StorageManagerService;
class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request): array
    {
        switch ($request->method()) {
            case self::METHOD_POST:
                return [
                    'name' => ['required', 'max:350'],
                    'name_ar' => ['required', 'max:350'],
                    'summary' => ['nullable'],
                    'summary_ar' => ['nullable'],
                    'parent_id' => ['nullable'],
                    'is_featured' => ['nullable'],
                    'image' => ['nullable', 'mimes:'.implode(',',StorageManagerService::$allowedImages)],
                ];
            case self::METHOD_PATCH:
                return [
                    'id' => ['required', 'exists:categories,id'],
                    'name' => ['required', 'max:350'],
                    'name_ar' => ['required', 'max:350'],
                    'summary' => ['nullable'],
                    'summary_ar' => ['nullable'],
                    'parent_id' => ['nullable'],
                    'is_featured' => ['nullable'],
                    'image' => ['nullable', 'mimes:'.implode(',',StorageManagerService::$allowedImages)],
                ];
            case self::METHOD_DELETE:
            default:
                return [
                    'id' => ['required', 'exists:categories,id']
                ];
        }
    }
    /**
     * @return array
     */
    public function messages()
    {
        return [
        ];
    }
}
