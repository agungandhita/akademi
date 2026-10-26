<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Pastikan pengguna telah terautentikasi
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Cek apakah akun aktif (AUTH-06)
        if (! $user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            Alert::error('Akun Nonaktif', 'Akun Anda dinonaktifkan. Silakan hubungi tim Administrator.');

            return redirect()->route('login');
        }

        // 3. Cek apakah role pengguna sesuai dengan yang diizinkan
        $currentRole = $user->role instanceof UserRole ? $user->role->value : (string) $user->role;

        if (! empty($roles) && ! in_array($currentRole, $roles, true)) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
