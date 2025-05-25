<?php

namespace App\Http\Requests;

use App\Models\Patient;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $patientId = $this->route('patient');
        $patient = Patient::findOrFail($patientId);
        $userId = $patient->user_id;

        return [
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $userId,
            'phone_number' => 'nullable|string|max:15',
            'postal_code' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'apartment_number' => 'nullable|string|max:10',
            'staircase_number' => 'nullable|string|max:10',
            'birth_date' => 'nullable|date|before:today',
        ];
    }
}
