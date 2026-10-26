<!-- Stitch Credible Vanguard Navbar -->
<header class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-b border-outline-variant shadow-[0_1px_8px_rgba(16,42,86,0.04)]">
    <div class="h-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        
        <!-- Brand Logo -->
        <div class="flex items-center gap-3">
            <a class="flex items-center gap-3 focus:outline-none focus:ring-2 focus:ring-secondary rounded-lg" href="{{ url('/') }}">
                <img src="{{ asset('img/logo.png') }}" alt="Akademi Pelatihan Logo" class="h-11 w-auto object-contain rounded-lg" />
                <div class="flex flex-col">
                    <span class="font-headline text-lg sm:text-xl font-bold text-primary tracking-tight leading-tight">
                        Akademi Pelatihan
                    </span>
                    <span class="text-[10px] sm:text-[11px] font-semibold text-outline uppercase tracking-wider">
                        Pusat Sertifikasi &amp; Kompetensi
                    </span>
                </div>
            </a>
        </div>

        <!-- Desktop Navigation Links -->
        <nav class="hidden lg:flex items-center gap-1.5 xl:gap-2">
            <a href="{{ url('/') }}" class="px-3.5 py-2 text-sm font-semibold transition-colors {{ request()->is('/') ? 'bg-surface-container text-secondary font-bold rounded-lg shadow-xs' : 'text-on-surface-variant hover:text-on-surface rounded-lg' }}">
                Beranda
            </a>
            <a href="{{ url('/agenda') }}" class="px-3.5 py-2 text-sm font-semibold transition-colors {{ request()->is('agenda*') ? 'bg-surface-container text-secondary font-bold rounded-lg shadow-xs' : 'text-on-surface-variant hover:text-on-surface rounded-lg' }}">
                Agenda Pelatihan
            </a>
            <a href="{{ url('/berita') }}" class="px-3.5 py-2 text-sm font-semibold transition-colors {{ request()->is('berita*') ? 'bg-surface-container text-secondary font-bold rounded-lg shadow-xs' : 'text-on-surface-variant hover:text-on-surface rounded-lg' }}">
                Berita &amp; Artikel
            </a>
            <a href="{{ url('/kontak') }}" class="px-3.5 py-2 text-sm font-semibold transition-colors {{ request()->is('kontak*') ? 'bg-surface-container text-secondary font-bold rounded-lg shadow-xs' : 'text-on-surface-variant hover:text-on-surface rounded-lg' }}">
                Kontak
            </a>
        </nav>

        <!-- Right Side: Actions & Profile -->
        <div class="flex items-center gap-3">
            @auth
                @php
                    $authUser = auth()->user();
                    $userRoleVal = $authUser?->role?->value ?? 'admin';
                    $dashboardUrl = url('/' . $userRoleVal);
                    $nameWords = array_values(array_filter(explode(' ', trim($authUser?->name ?? ''))));
                    $initials = count($nameWords) >= 2 
                        ? strtoupper(substr($nameWords[0], 0, 1) . substr($nameWords[1], 0, 1)) 
                        : strtoupper(substr($authUser?->name ?? 'AP', 0, 2));
                @endphp
                <div class="hidden sm:flex items-center gap-3">
                    <a href="{{ $dashboardUrl }}" class="px-4 py-2 rounded-lg bg-surface-container text-primary hover:bg-secondary hover:text-white transition-all font-semibold text-sm">
                        Dashboard
                    </a>
                    <div class="flex items-center pl-2 border-l border-outline-variant">
                        <a href="{{ $dashboardUrl }}" title="{{ $authUser?->name ?? 'Profil' }}" class="flex items-center justify-center w-9 h-9 rounded-full bg-surface-container-high ring-2 ring-surface-container text-secondary font-bold text-xs hover:ring-secondary transition-all overflow-hidden">
                            @if(!empty($authUser?->avatar))
                                <img src="{{ asset('storage/' . $authUser->avatar) }}" alt="{{ $authUser->name }}" class="w-full h-full object-cover">
                            @else
                                {{ $initials }}
                            @endif
                        </a>
                    </div>
                </div>
            @else
                <div class="hidden sm:flex items-center gap-2">
                    <a href="{{ url('/login') }}" class="px-4 py-2 rounded-lg border border-outline-variant text-on-surface hover:bg-surface-container-low hover:text-primary transition-all font-semibold text-sm">
                        Masuk
                    </a>
                    <a href="{{ url('/register') }}" class="px-4 py-2 rounded-lg bg-secondary text-white shadow-sm hover:bg-secondary-container transition-all font-semibold text-sm">
                        Daftar
                    </a>
                </div>
            @endauth

            <!-- Mobile Menu Toggle Button -->
            <button id="stitch-mobile-btn" aria-label="Menu Utama" class="lg:hidden flex items-center justify-center p-2 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" type="button">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>

    </div>

    <!-- Mobile Dropdown -->
    <div id="stitch-mobile-menu" class="hidden lg:hidden px-4 pt-2 pb-5 bg-white border-t border-outline-variant space-y-2">
        <a href="{{ url('/') }}" class="block px-3 py-2 text-sm rounded-lg {{ request()->is('/') ? 'font-bold text-secondary bg-surface-container' : 'font-semibold text-on-surface-variant hover:bg-surface-container' }}">
            Beranda
        </a>
        <a href="{{ url('/agenda') }}" class="block px-3 py-2 text-sm rounded-lg {{ request()->is('agenda*') ? 'font-bold text-secondary bg-surface-container' : 'font-semibold text-on-surface-variant hover:bg-surface-container' }}">
            Agenda Pelatihan
        </a>
        <a href="{{ url('/berita') }}" class="block px-3 py-2 text-sm rounded-lg {{ request()->is('berita*') ? 'font-bold text-secondary bg-surface-container' : 'font-semibold text-on-surface-variant hover:bg-surface-container' }}">
            Berita &amp; Artikel
        </a>
        <a href="{{ url('/kontak') }}" class="block px-3 py-2 text-sm rounded-lg {{ request()->is('kontak*') ? 'font-bold text-secondary bg-surface-container' : 'font-semibold text-on-surface-variant hover:bg-surface-container' }}">
            Kontak
        </a>
        <div class="pt-3 border-t border-outline-variant flex flex-col gap-2">
            @auth
                @php
                    $mobileDashboardUrl = url('/' . (auth()->user()?->role?->value ?? 'admin'));
                @endphp
                <a href="{{ $mobileDashboardUrl }}" class="w-full text-center py-2.5 rounded-lg bg-surface-container text-primary font-bold text-sm">
                    Dashboard
                </a>
            @else
                <a href="{{ url('/login') }}" class="w-full text-center py-2.5 rounded-lg border border-outline-variant text-on-surface font-semibold text-sm">
                    Masuk
                </a>
                <a href="{{ url('/register') }}" class="w-full text-center py-2.5 rounded-lg bg-secondary text-white font-semibold text-sm">
                    Daftar Pelatihan
                </a>
            @endauth
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('stitch-mobile-btn');
    const menu = document.getElementById('stitch-mobile-menu');
    if (btn && menu) {
        btn.addEventListener('click', function () {
            menu.classList.toggle('hidden');
        });
    }
});
</script>
