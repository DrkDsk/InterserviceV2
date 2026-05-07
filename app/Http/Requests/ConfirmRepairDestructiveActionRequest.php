<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ConfirmRepairDestructiveActionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'confirmation' => ['required', 'string', Rule::in(['Eliminar'])],
        ];
    }

    public function messages(): array
    {
        return [
            'confirmation.required' => 'Escribe "Eliminar" para continuar.',
            'confirmation.in' => 'La confirmación debe coincidir exactamente con "Eliminar".',
        ];
    }
}
