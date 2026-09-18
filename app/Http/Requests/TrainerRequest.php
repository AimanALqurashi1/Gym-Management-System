<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainerRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:members,email',
            'date_of_birth' => 'required|date|before:' . now()->subYears(10)->format('Y-m-d'),
            'gender' => 'required|in:male,female',
            'phone' => 'required|string|min:10|max:20|regex:/^([0-9\s\-\+\(\)]*)$/',
            'weight' => 'nullable|numeric|min:30|max:300',
            'height' => 'nullable|numeric|min:50|max:250',
            'nationality' => 'required|string|max:100',
            'address' => 'nullable|string|max:500',

        ];
    }
}
