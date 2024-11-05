<?php

namespace App\Domains\Lookups\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 *
 */
class PageRequest extends FormRequest
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
                    'title' => ['required', 'max:255'],
                    'title_ar' => ['required', 'max:255'],
                    'description' => ['required'],
                    'description_ar' => ['required'],
                ];
            case self::METHOD_PATCH:
                return [
                    'id' => ['required', 'exists:pages,id'],
                    'title' => ['required', 'max:255'],
                    'title_ar' => ['required', 'max:255'],
                    'description' => ['required'],
                    'description_ar' => ['required'],
                ];
            case self::METHOD_DELETE:
            default:
                return [
                    'id' => ['required', 'exists:pages,id']
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


