<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCertificateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'certificate_number' => ['nullable', 'string', 'max:255'],
            'certificate_date' => ['nullable', 'string', 'max:255'],
            'certificate_signer_left_title' => ['nullable', 'string', 'max:255'],
            'certificate_signer_left_name' => ['nullable', 'string', 'max:255'],
            'certificate_signer_left_nip' => ['nullable', 'string', 'max:255'],
            'certificate_signer_left_signature' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
            'certificate_signer_right_title' => ['nullable', 'string', 'max:255'],
            'certificate_signer_right_name' => ['nullable', 'string', 'max:255'],
            'certificate_signer_right_nip' => ['nullable', 'string', 'max:255'],
            'certificate_signer_right_signature' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
            'is_certificate_enabled' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Custom attribute names for validation errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'certificate_number' => 'Nomor Kegiatan',
            'certificate_date' => 'Tanggal Kegiatan',
            'certificate_signer_left_title' => 'Jabatan Penandatangan Kiri',
            'certificate_signer_left_name' => 'Nama Penandatangan Kiri',
            'certificate_signer_left_nip' => 'NIP Penandatangan Kiri',
            'certificate_signer_left_signature' => 'File Tanda Tangan Kiri',
            'certificate_signer_right_title' => 'Jabatan Penandatangan Kanan',
            'certificate_signer_right_name' => 'Nama Penandatangan Kanan',
            'certificate_signer_right_nip' => 'NIP Penandatangan Kanan',
            'certificate_signer_right_signature' => 'File Tanda Tangan Kanan',
            'is_certificate_enabled' => 'Status Terbit Sertifikat',
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
            'certificate_signer_left_signature.image' => 'File tanda tangan kiri harus berupa berkas gambar.',
            'certificate_signer_left_signature.mimes' => 'Format tanda tangan kiri yang didukung adalah PNG, JPG, JPEG, atau WebP.',
            'certificate_signer_left_signature.max' => 'Ukuran file tanda tangan kiri maksimal 2 MB.',
            'certificate_signer_right_signature.image' => 'File tanda tangan kanan harus berupa berkas gambar.',
            'certificate_signer_right_signature.mimes' => 'Format tanda tangan kanan yang didukung adalah PNG, JPG, JPEG, atau WebP.',
            'certificate_signer_right_signature.max' => 'Ukuran file tanda tangan kanan maksimal 2 MB.',
        ];
    }
}

