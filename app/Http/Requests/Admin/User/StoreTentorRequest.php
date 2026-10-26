<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreTentorRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string'],
            'expertise' => ['nullable', 'string', 'max:255'],
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap tentor wajib diisi.',
            'email.required' => 'Alamat email tentor wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'password.required' => 'Kata sandi awal wajib ditentukan.',
            'password.min' => 'Kata sandi minimal berjumlah 8 karakter.',
            'avatar.required' => 'Foto profil tentor wajib diunggah.',
            'avatar.image' => 'File yang diunggah harus berupa gambar valid.',
            'avatar.mimes' => 'Format foto harus berupa JPG, JPEG, PNG, atau WEBP.',
            'avatar.max' => 'Ukuran foto maksimal adalah 10MB.',
        ];
    }
}
