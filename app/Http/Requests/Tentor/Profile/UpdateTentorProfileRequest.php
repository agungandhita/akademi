<?php

namespace App\Http\Requests\Tentor\Profile;

use App\DTOs\Users\UpdateUserDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTentorProfileRequest extends FormRequest
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
        $userId = $this->user()?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'phone' => ['nullable', 'string', 'max:20'],
            'institution' => ['nullable', 'string', 'max:255'],
            'expertise' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'password' => ['nullable', 'string', 'min:8'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
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
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email sudah digunakan oleh pengguna lain.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'avatar.image' => 'Berkas foto profil harus berupa gambar.',
            'avatar.max' => 'Ukuran foto profil maksimal 10 MB.',
        ];
    }

    public function toDTO(?string $avatarPath = null): UpdateUserDTO
    {
        $data = $this->validated();
        if ($avatarPath) {
            $data['avatar'] = $avatarPath;
        }

        return UpdateUserDTO::fromArray($data);
    }
}
