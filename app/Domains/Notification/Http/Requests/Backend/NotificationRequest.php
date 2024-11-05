<?php
namespace App\Domains\Notification\Http\Requests\Backend;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\StorageManagerService;

class NotificationRequest extends FormRequest
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
                    'description' => ['required', 'max:350'],
                    'description_ar' => ['required'],
                    'type' => ['required', 'max:350'],
                    'notification_icon' => ['required', 'mimes:'.implode(',',StorageManagerService::$allowedImages)],
                ];
            case self::METHOD_PATCH:
                return [
                    'id' => ['required', 'exists:notifications,id'],
                    'title' => ['required', 'max:350'],
                    'title_ar' => ['required', 'max:350'],
                    'description' => ['required', 'max:350'],
                    'description_ar' => ['required'],
                    'type' => ['required', 'max:350'],
                    'notification_icon' => ['nullable', 'mimes:'.implode(',',StorageManagerService::$allowedImages)],
                ];
            case self::METHOD_DELETE:
            default:
                return [
                    'id' => ['required', 'exists:notifications,id']
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
