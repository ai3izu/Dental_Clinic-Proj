<?php

namespace App\Http\Requests;

use App\Models\Doctor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth; // Dodaj tę linię

class UpdateDoctorRequest extends FormRequest
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
        $userIdToIgnore = null;
        if ($this->route('doctor')) {
            $doctorId = $this->route('doctor');
            $doctor = Doctor::findOrFail($doctorId);
            $userIdToIgnore = $doctor->user_id;
        } else if (Auth::check()) {
            $userIdToIgnore = Auth::id();
        }

        return [
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $userIdToIgnore,
            'password' => 'nullable|string|min:8|confirmed',
            'specialization' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:15',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_alt' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:2000',
        ];
    }
}
