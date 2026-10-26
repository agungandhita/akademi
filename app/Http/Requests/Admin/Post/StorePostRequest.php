<?php

namespace App\Http\Requests\Admin\Post;

use App\Enums\PostStatus;
use App\Enums\PostType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
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
            'type' => ['required', Rule::enum(PostType::class)],
            'excerpt' => ['required', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'status' => ['required', Rule::enum(PostStatus::class)],
            'published_at' => ['nullable', 'date'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul konten wajib diisi.',
            'title.max' => 'Judul tidak boleh melebihi 255 karakter.',
            'type.required' => 'Tipe konten (Berita / Artikel) wajib dipilih.',
            'excerpt.required' => 'Ringkasan singkat wajib diisi.',
            'excerpt.max' => 'Ringkasan tidak boleh melebihi 500 karakter.',
            'content.required' => 'Isi konten lengkap wajib diisi.',
            'cover.image' => 'File cover harus berupa gambar.',
            'cover.mimes' => 'Format gambar yang didukung: JPEG, PNG, JPG, WEBP.',
            'cover.max' => 'Ukuran gambar maksimal 2 MB.',
            'status.required' => 'Status publikasi wajib dipilih.',
            'published_at.date' => 'Format tanggal publikasi tidak valid.',
        ];
    }
}
