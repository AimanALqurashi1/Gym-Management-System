<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
            'status' => 'required|in:active,pending,suspended,expired,cancelled',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The member name is required.',
            'name.max' => 'The member name cannot exceed 255 characters.',

            'email.required' => 'The email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',

            'date_of_birth.required' => 'The date of birth is required.',
            'date_of_birth.date' => 'Please enter a valid date.',
            'date_of_birth.before' => 'Member must be at least 10 years old.',

            'gender.required' => 'Please select a gender.',
            'gender.in' => 'Gender must be either Male or Female.',

            'phone.required' => 'The phone number is required.',
            'phone.min' => 'Phone number must be at least 10 characters.',
            'phone.regex' => 'Please enter a valid phone number.',

            'weight.min' => 'Weight must be at least 30 kg.',
            'weight.max' => 'Weight cannot exceed 300 kg.',
            'weight.numeric' => 'Weight must be a number.',

            'height.min' => 'Height must be at least 50 cm.',
            'height.max' => 'Height cannot exceed 250 cm.',
            'height.numeric' => 'Height must be a number.',

            'nationality.required' => 'Please select a nationality.',

            'status.required' => 'Please select a status.',
            'status.in' => 'Please select a valid status.',

            'photo.image' => 'The file must be an image.',
            'photo.mimes' => 'Only JPEG, PNG, and JPG images are allowed.',
            'photo.max' => 'Image size cannot exceed 2MB.'
        ];
    }
}
