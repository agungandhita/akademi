<?php

namespace App\Http\Requests\Admin\Training;

use App\Enums\TrainingAudience;
use App\Enums\TrainingMode;
use App\Enums\TrainingStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTrainingRequest extends FormRequest
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
            
            // Aturan Bisnis 7: Field wajib berbasis mode pelatihan
            'meeting_url' => ['nullable', 'string', 'max:255', Rule::requiredIf(fn () => $this->input('mode') === TrainingMode::Online->value)],
            'location' => ['nullable', 'string', 'max:255', Rule::requiredIf(fn () => $this->input('mode') === TrainingMode::Offline->value)],
            'whatsapp_group_link' => ['nullable', 'url', 'max:255'],
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
            'category_id.required' => 'Kategori pelatihan wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'title.required' => 'Judul pelatihan wajib diisi.',
            'description.required' => 'Deskripsi pelatihan wajib diisi.',
            'start_date.required' => 'Tanggal mulai pelaksanaan wajib ditentukan.',
            'end_date.required' => 'Tanggal selesai pelaksanaan wajib ditentukan.',
            'end_date.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
            'meeting_url.required' => 'Tautan meeting (Zoom/Google Meet) wajib diisi untuk pelatihan mode Online.',
            'location.required' => 'Lokasi venue fisik wajib diisi untuk pelatihan mode Offline.',
            'whatsapp_group_link.url' => 'Tautan grup WhatsApp harus berupa format URL yang valid (contoh: https://chat.whatsapp.com/...).',
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
