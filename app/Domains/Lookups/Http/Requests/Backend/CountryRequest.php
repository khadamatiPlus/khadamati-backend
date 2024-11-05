<?php

namespace App\Domains\Lookups\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
/**
 * Class CountryRequest.
 */
class CountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
        switch ($request->method()){
            case self::METHOD_POST:
                return [
                    'name' => ['required', 'max:255'],
                    'name_ar' => ['required', 'max:255'],
                    'code' => ['required', 'max:255'],
                    'phone_code' => ['required', 'max:11']
                ];
            case self::METHOD_PATCH:
                return [
                    'id' => ['required', 'exists:countries,id'],
                    'name' => ['required', 'max:255'],
                    'name_ar' => ['required', 'max:255'],
                    'code' => ['required', 'max:255'],
                    'phone_code' => ['required', 'max:11']
                ];
            case self::METHOD_DELETE:
            default:
                return [
                    'id' => ['required', 'exists:countries,id']
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
