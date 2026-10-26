<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    /**
     * Tampilkan formulir login.
     */
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.Login.login', [
            'title' => 'Masuk - Akademi Pelatihan',
            'metaDescription' => 'Masuk ke portal pembelajaran dan dashboard Akademi Pelatihan Indonesia.',
        ]);
    }

    /**
     * Tangani permintaan autentikasi login.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        Alert::success('Berhasil Masuk', 'Selamat datang kembali, '.$user->name.'!');

        return $this->redirectByRole($user);
    }

    /**
     * Tangani permintaan logout pengguna.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Alert::info('Sampai Jumpa', 'Anda telah berhasil keluar dari sistem Akademi Pelatihan.');

        return redirect()->route('login');
    }

    /**
     * Alihkan pengguna ke dashboard yang sesuai dengan peran mereka (AUTH-03).
     */
    protected function redirectByRole($user): RedirectResponse
    {
        if ($user->isAdmin()) {
            return redirect()->intended(route('admin'));
        }

        if ($user->isTentor()) {
            return redirect()->intended(route('tentor'));
        }

        return redirect()->intended(route('peserta'));
    }
}
