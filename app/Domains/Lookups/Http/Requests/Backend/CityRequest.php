<?php

namespace App\Domains\Lookups\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Class CityRequest.
 */
class CityRequest extends FormRequest
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
                    'country_id' => ['required', 'max:20'],
                ];
            case self::METHOD_PATCH:
                return [
                    'id' => ['required', 'exists:cities,id'],
                    'name' => ['required', 'max:255'],
                    'name_ar' => ['required', 'max:255'],
                    'country_id' => ['required', 'max:20'],
                ];
            case self::METHOD_DELETE:
            default:
                return [
                    'id' => ['required', 'exists:cities,id']
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

