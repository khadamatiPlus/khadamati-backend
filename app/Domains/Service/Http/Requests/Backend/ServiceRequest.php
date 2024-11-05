<?php
namespace App\Domains\Service\Http\Requests\Backend;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\StorageManagerService;

class ServiceRequest extends FormRequest
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
                    'mobile_number' => ['required', 'max:350'],
                    'price' => ['required', 'max:350'],
                    'location' => ['required'],
                    'location_ar' => ['required'],
                    'order' => ['nullable'],
                    'duration' => ['nullable'],
                    'category_id' => ['required','exists:categories,id'],
                    'sub_category_id' => ['required','exists:categories,id'],
                    'merchant_id' => ['required','exists:merchants,id'],
                    'country_id' => ['required','exists:countries,id'],
                    'city_id' => ['required','exists:cities,id'],
                    'area_id' => ['required','exists:areas,id'],
                    'main_image' => ['nullable', 'mimes:'.implode(',',StorageManagerService::$allowedImages)],
                    'video' => ['nullable', 'mimes:'.implode(',',StorageManagerService::$allowedVideos)],
                ];
            case self::METHOD_PATCH:
                return [
                    'id' => ['required', 'exists:services,id'],
                    'title' => ['required', 'max:350'],
                    'title_ar' => ['required', 'max:350'],
                    'description' => ['required'],
                    'description_ar' => ['required'],
                    'mobile_number' => ['required', 'max:350'],
                    'price' => ['required', 'max:350'],
                    'location' => ['required'],
                    'location_ar' => ['required'],
                    'order' => ['nullable'],
                    'duration' => ['nullable'],
                    'category_id' => ['required','exists:categories,id'],
                    'sub_category_id' => ['required','exists:categories,id'],
                    'merchant_id' => ['required','exists:merchants,id'],
                    'country_id' => ['required','exists:countries,id'],
                    'city_id' => ['required','exists:cities,id'],
                    'area_id' => ['required','exists:areas,id'],
                    'main_image' => ['nullable', 'mimes:'.implode(',',StorageManagerService::$allowedImages)],
                    'video' => ['nullable', 'mimes:'.implode(',',StorageManagerService::$allowedVideos)],
                ];
            case self::METHOD_DELETE:
            default:
                return [
                    'id' => ['required', 'exists:services,id']
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
