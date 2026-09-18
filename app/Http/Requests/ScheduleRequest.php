<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
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
            'member_id' => 'required|exists:members,id',
            'trainer_id' => 'required|exists:trainers,id',
            'course_id' => 'required|exists:courses,id',
            'day_of_week' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'schedule_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|string',
            'end_time' => 'required|string|after:start_time',
            'recurrence_type' => 'required|string|in:none,daily,weekly,biweekly,monthly',
            'recurrence_start_date' => 'required|date',
            'recurrence_end_date' => 'nullable|date|after_or_equal:recurrence_start_date',
            'is_active' => 'nullable|boolean',
            'is_group_schedule' => 'nullable|boolean',
            'notes' => 'nullable|string|max:500',
            'avaliable_spots' => 'required|integer',

        ];
    }
}
