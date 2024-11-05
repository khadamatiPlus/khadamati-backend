<?php

namespace App\Domains\Social\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Class SiteSettingRequest.
 */
class SocialRequest extends FormRequest
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
                    'x' => ['nullable', 'max:255'],
                    'whatsapp' => ['nullable', 'max:255'],
                    'tiktok' => ['nullable', 'max:255'],
                    'youtube' => ['nullable', 'max:255'],
                    'facebook' => ['nullable', 'max:255'],
                    'instagram' => ['nullable', 'max:255'],
                    'snapchat' => ['nullable', 'max:255'],
                ];
            case self::METHOD_PATCH:
                return [
                    'id' => ['required', 'exists:socials,id'],
                    'x' => ['nullable', 'max:255'],
                    'whatsapp' => ['nullable', 'max:255'],
                    'tiktok' => ['nullable', 'max:255'],
                    'youtube' => ['nullable', 'max:255'],
                    'facebook' => ['nullable', 'max:255'],
                    'instagram' => ['nullable', 'max:255'],
                    'snapchat' => ['nullable', 'max:255'],
                ];
            case self::METHOD_DELETE:
            default:
                return [
                    'id' => ['required', 'exists:socials,id']
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

