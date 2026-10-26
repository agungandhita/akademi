<header class="fixed top-0 left-0 right-0 z-40 bg-surface-container-lowest/95 backdrop-blur-md border-b border-outline-variant/60 h-16 flex items-center px-4 sm:px-6 shadow-xs">
    <div class="flex items-center justify-between w-full">
        
        <!-- Left: Brand & Mobile Sidebar Toggle -->
        <div class="flex items-center gap-3">
            <button id="sidebar-toggle-btn" type="button" class="lg:hidden p-2 rounded-lg text-on-surface-variant hover:text-primary hover:bg-surface-container focus:outline-none" aria-label="Toggle Sidebar">
                <span class="material-symbols-outlined text-[24px]">menu</span>
            </button>

            @php
                $userRoleVal = auth()->user()?->role?->value ?? 'admin';
                $dashboardUrl = url('/' . $userRoleVal);
            @endphp

            <a href="{{ $dashboardUrl }}" class="flex items-center gap-2.5">
                <img src="{{ asset('img/logo.png') }}" alt="Akademi Pelatihan" class="h-9 w-auto object-contain" />
                <div class="hidden sm:flex flex-col">
                    <span class="font-headline text-sm font-extrabold text-primary leading-tight">AKADEMI <span class="text-secondary">PELATIHAN</span></span>
                    <span class="text-[10px] font-bold text-outline tracking-wider uppercase">Portal Terpadu</span>
                </div>
            </a>
        </div>

        <!-- Center: Quick Search Input -->
        <div class="hidden md:flex items-center flex-1 max-w-md mx-8">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                </div>
                <input type="text" placeholder="Cari pelatihan, modul, peserta..." 
                    class="w-full pl-9 pr-4 py-2 text-xs text-on-surface bg-surface-container-low border border-outline-variant/60 rounded-xl focus:bg-white focus:ring-2 focus:ring-secondary/40 focus:border-secondary outline-none transition-all placeholder:text-outline" />
            </div>
        </div>

        <!-- Right: Actions & User Dropdown -->
        <div class="flex items-center gap-3">
            
            <!-- Quick View Web Button -->
            <a href="{{ url('/') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 text-xs font-semibold text-on-surface-variant hover:text-secondary px-3 py-1.5 rounded-lg border border-outline-variant/60 hover:bg-surface-container-low transition-colors">
                <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                <span>Lihat Website</span>
            </a>

            <!-- User Info & Dropdown -->
            @auth
            <div class="relative" id="admin-profile-container">
                <button type="button" id="admin-profile-btn" class="flex items-center gap-2.5 p-1.5 rounded-xl hover:bg-surface-container transition-colors cursor-pointer">
                    @php
                        $user = auth()->user();
                        $words = explode(' ', $user->name);
                        $initials = count($words) >= 2 
                            ? strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1)) 
                            : strtoupper(substr($user->name, 0, 2));
                        $roleBadgeClass = $user->role?->badgeClass() ?? 'bg-primary text-white';
                        $roleLabel = $user->role?->label() ?? 'Pengguna';
                    @endphp
                    <div class="w-8 h-8 rounded-full bg-primary text-white font-headline font-bold text-xs flex items-center justify-center shadow-xs ring-1 ring-secondary/30">
                        {{ $initials }}
                    </div>
                    <div class="hidden sm:block text-left">
                        <p class="text-xs font-bold text-primary leading-tight truncate max-w-[140px]">{{ $user->name }}</p>
                        <span class="inline-block px-1.5 py-0.2 rounded text-[10px] font-semibold {{ $roleBadgeClass }}">
                            {{ $roleLabel }}
                        </span>
                    </div>
                    <span class="material-symbols-outlined text-[18px] text-outline hidden sm:block">expand_more</span>
                </button>

                <!-- Profile Dropdown Menu -->
                <div id="admin-profile-menu" class="hidden absolute right-0 mt-2 w-56 bg-surface-container-lowest rounded-2xl shadow-xl border border-outline-variant/60 py-2 z-50">
                    <div class="px-4 py-2.5 border-b border-outline-variant/40">
                        <p class="text-xs font-bold text-primary truncate">{{ $user->name }}</p>
                        <p class="text-[11px] text-on-surface-variant truncate">{{ $user->email }}</p>
                        <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-semibold {{ $roleBadgeClass }}">
                            {{ $roleLabel }}
                        </span>
                    </div>
                    <a href="{{ $dashboardUrl }}" class="flex items-center gap-2 px-4 py-2 text-xs text-on-surface-variant hover:bg-surface-container-low hover:text-secondary transition-colors">
                        <span class="material-symbols-outlined text-[16px]">dashboard</span>
                        <span>Dashboard Utama</span>
                    </a>
                    <a href="{{ url('/') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-on-surface-variant hover:bg-surface-container-low hover:text-secondary transition-colors">
                        <span class="material-symbols-outlined text-[16px]">public</span>
                        <span>Beranda Publik</span>
                    </a>
                    <div class="border-t border-outline-variant/40 my-1"></div>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-xs text-error hover:bg-error-container/20 font-semibold transition-colors text-left cursor-pointer">
                            <span class="material-symbols-outlined text-[16px]">logout</span>
                            <span>Keluar (Logout)</span>
                        </button>
                    </form>
                </div>
            </div>
            @endauth

        </div>

    </div>
</header>
