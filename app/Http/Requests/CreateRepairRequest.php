<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateRepairRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $clientId = $this->has('client_id');
        $customerName = $this->has('customer_name');

        $needsClient = (!$clientId && (!$customerName));
        $validatorClient = $needsClient ? 'required' : 'nullable';

        return [
            'client_id' => "$validatorClient|exists:clients,id",
            'customer_name' => 'nullable|string',
            'customer_phone' => 'nullable|string',
            'notes' => 'nullable|string',
            'device_category_id' => 'nullable|exists:device_categories,id',
            'brand' => 'nullable|string',
            'model' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'inventory_number' => 'nullable|string',
            'password' => 'nullable|string',
            'issue' => 'required|string',
            'observations' => 'nullable|string',
            'accessories' => 'nullable|string',
            'service_id' => 'nullable|exists:services,id',
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.required' => __('validation.required'),
            'client_id.exists' => __('validation.exists'),
            'customer_name.required' => __('validation.required'),
            'issue.required' => __('validation.required'),
            'service_id.exists' => __('validation.exists'),
            'device_category_id.exists' => __('validation.exists'),
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            "client_id" => $this->client_id ?? null,
            "device_category_id" => $this->device_category_id ?? null,
            "notes" => $this->notes ?? null,
            "brand" => $this->brand ?? null,
            "model" => $this->model ?? null,
            "serial_number" => $this->serial_number ?? null,
            "inventory_number" => $this->inventory_number ?? null,
            "password" => $this->password ?? null,
            "observations" => $this->observations ?? null,
            "accessories" => $this->accessories ?? null,
        ]);
    }
}
