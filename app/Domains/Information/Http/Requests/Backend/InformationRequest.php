<?php

namespace App\Domains\Information\Http\Requests\Backend;

use App\Domains\Information\Models\Information;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Class InformationRequest.
 */
class InformationRequest extends FormRequest
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
            case self::METHOD_PATCH:
                return [
                    'id' => ['required', 'exists:information,id'],
                    'email' => ['nullable', 'max:2550'],
                    'phone_number' => ['nullable', 'max:2550'],
                    'second_phone_number' => ['nullable', 'max:2550'],
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

