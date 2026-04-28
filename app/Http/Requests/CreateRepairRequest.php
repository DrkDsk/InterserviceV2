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

    public function attributes(): array
    {
        return [
            'client_id' => 'cliente',
        ];
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
        $customerPhone = $this->has('customer_phone');

        $needsClient = (!$clientId && (!$customerName && !$customerPhone));

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
            'service_id' => 'nullable|exists:services,id',
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.required' => __('validation.required'),
            'client_id.exists' => 'El campo :attribute seleccionado no existe.',
            'customer_name.required' => 'El campo nombre del cliente es obligatorio.',
            'issue.required' => 'El campo problema es obligatorio.',
            'service_id.exists' => 'El servicio seleccionado no existe.',
            'device_category_id.exists' => 'La categoría del dispositivo seleccionada no existe.'
        ];
    }
}
