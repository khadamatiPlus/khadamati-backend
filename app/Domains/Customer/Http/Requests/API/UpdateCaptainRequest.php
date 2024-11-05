<?php

namespace App\Domains\Captain\Http\Requests\API;

use App\Enums\Core\ErrorTypes;
use App\Http\Requests\JsonRequest;
use App\Services\StorageManagerService;
use Illuminate\Validation\Rule;

class UpdateCaptainRequest extends JsonRequest
{
    /**
     * @var int $errorType
     */
    protected int $errorType = ErrorTypes::CAPTAIN;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->isCaptain();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => !empty($this->name)?['max:350']:'',
            'profile_pic' => !empty($this->personal_photo)?['sometimes', 'mimes:'.implode(',',StorageManagerService::$allowedImages)]:'',
            'driving_license_card' => !empty($this->personal_photo)?['sometimes', 'mimes:'.implode(',',StorageManagerService::$allowedImages)]:'',
            'car_id_card' => !empty($this->personal_photo)?['sometimes', 'mimes:'.implode(',',StorageManagerService::$allowedImages)]:'',
            'vehicle_type_id' => ['nullable','exists:vehicle_types,id'],
            'cities' => ['nullable'],

        ];
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
