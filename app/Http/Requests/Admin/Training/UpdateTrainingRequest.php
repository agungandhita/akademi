<?php

namespace App\Http\Requests\Admin\Training;

use App\Enums\TrainingAudience;
use App\Enums\TrainingMode;
use App\Enums\TrainingStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTrainingRequest extends FormRequest
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
            'category_id' => ['required', 'exists:training_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'audience' => ['required', Rule::enum(TrainingAudience::class)],
            'mode' => ['required', Rule::enum(TrainingMode::class)],
            'status' => ['required', Rule::enum(TrainingStatus::class)],
            'quota' => ['nullable', 'integer', 'min:1'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'registration_start' => ['nullable', 'date'],
            'registration_end' => ['nullable', 'date', 'after_or_equal:registration_start'],
            
            // Aturan Bisnis 7
            'meeting_url' => ['nullable', 'string', 'max:255', Rule::requiredIf(fn () => $this->input('mode') === TrainingMode::Online->value)],
            'location' => ['nullable', 'string', 'max:255', Rule::requiredIf(fn () => $this->input('mode') === TrainingMode::Offline->value)],
            'is_free' => ['required', 'boolean'],
            'price' => ['nullable', 'numeric', 'min:0', Rule::requiredIf(fn () => ! $this->boolean('is_free'))],
            'thumbnail' => $this->hasFile('thumbnail')
                ? ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240']
                : ['nullable', 'string', 'max:500'],
            'facilities' => ['nullable', 'array'],
            'facilities.*' => ['string', 'max:255'],
            'instructors' => ['nullable', 'array'],
            'instructors.*' => ['exists:users,id'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'meeting_url.required' => 'Tautan meeting (Zoom/Google Meet) wajib diisi untuk pelatihan mode Online.',
            'location.required' => 'Lokasi venue fisik wajib diisi untuk pelatihan mode Offline.',
            'is_free.required' => 'Skema biaya pendaftaran (Gratis / Berbayar) wajib ditentukan.',
            'price.required' => 'Nominal biaya pelatihan wajib diisi jika pelatihan berbayar.',
            'price.numeric' => 'Nominal biaya pelatihan harus berupa angka.',
            'price.min' => 'Nominal biaya pelatihan tidak boleh kurang dari 0.',
            'thumbnail.image' => 'Berkas sampul harus berupa gambar valid.',
            'thumbnail.mimes' => 'Format gambar sampul harus JPEG, PNG, JPG, atau WEBP.',
            'thumbnail.max' => 'Ukuran berkas gambar sampul maksimal 10MB.',
        ];
    }
}
