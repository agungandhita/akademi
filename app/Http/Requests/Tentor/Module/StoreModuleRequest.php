<?php

namespace App\Http\Requests\Tentor\Module;

use App\DTOs\Modules\CreateModuleDTO;
use App\Enums\ModuleStatus;
use App\Enums\ModuleType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreModuleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role?->value === 'tentor';
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'training_id' => ['required', 'exists:trainings,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'type' => ['required', Rule::enum(ModuleType::class)],
            'content' => ['nullable', 'string'],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'url' => ['nullable', 'url', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', Rule::enum(ModuleStatus::class)],
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'training_id.required' => 'Pilih pelatihan terlebih dahulu.',
            'training_id.exists' => 'Pelatihan yang dipilih tidak valid.',
            'title.required' => 'Judul modul wajib diisi.',
            'title.max' => 'Judul modul maksimal 255 karakter.',
            'type.required' => 'Pilih jenis format materi modul.',
            'file.mimes' => 'Berkas modul harus berformat PDF.',
            'file.max' => 'Ukuran berkas PDF maksimal 10 MB.',
            'url.url' => 'Format tautan URL tidak valid.',
            'status.required' => 'Status publikasi modul wajib dipilih.',
        ];
    }

    public function toDTO(int $createdBy, ?string $filePath = null): CreateModuleDTO
    {
        $data = $this->validated();
        if ($filePath) {
            $data['file_path'] = $filePath;
        }

        return CreateModuleDTO::fromArray($data, $createdBy);
    }
}
