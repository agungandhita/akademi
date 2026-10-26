<?php

namespace App\Http\Requests\Admin\TrainingSession;

use App\Enums\SessionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTrainingSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'session_type' => ['required', Rule::enum(SessionType::class)],
            'session_date' => ['required', 'date'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'location' => ['nullable', 'string', 'max:255'],
            'meeting_url' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
