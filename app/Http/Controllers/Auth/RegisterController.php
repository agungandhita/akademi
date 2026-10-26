<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\User\UserInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    public function __construct(
        protected readonly UserInterface $userService
    ) {}

    /**
     * Tampilkan formulir pendaftaran peserta baru.
     */
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('login');
        }

        return view('auth.Register.register', [
            'title' => 'Daftar Pelatihan - Akademi Pelatihan',
            'metaDescription' => 'Pendaftaran akun peserta baru untuk guru, siswa, dan masyarakat umum di Akademi Pelatihan.',
        ]);
    }

    /**
     * Tangani permintaan pendaftaran peserta baru.
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $dto = $request->toDTO();

        $user = $this->userService->registerPeserta($dto);

        Alert::success(
            'Pendaftaran Berhasil',
            'Akun '.$user->name.' berhasil terdaftar sebagai '.$user->participant_type?->label().'. Silakan masuk.'
        );

        return redirect()->route('login');
    }
}
