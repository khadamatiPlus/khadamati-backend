<?php
namespace App\Domains\Introduction\Http\Requests\Backend;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\StorageManagerService;

class IntroductionRequest extends FormRequest
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
                    'title' => ['required', 'max:350'],
                    'title_ar' => ['required', 'max:350'],
                    'description' => ['required'],
                    'description_ar' => ['required'],
                    'image' => ['required', 'mimes:'.implode(',',StorageManagerService::$allowedImages)],
                ];
            case self::METHOD_PATCH:
                return [
                    'id' => ['required', 'exists:introductions,id'],
                    'title' => ['required', 'max:350'],
                    'title_ar' => ['required', 'max:350'],
                    'description' => ['required'],
                    'description_ar' => ['required'],
                    'image' => ['nullable', 'mimes:'.implode(',',StorageManagerService::$allowedImages)],
                ];
            case self::METHOD_DELETE:
            default:
                return [
                    'id' => ['required', 'exists:introductions,id']
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
