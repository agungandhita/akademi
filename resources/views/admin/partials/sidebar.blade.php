<!-- Sidebar Navigation Container -->
@php
    $activeRole = auth()->user()?->role?->value ?? ($currentRole ?? 'admin');
@endphp

<aside id="admin-sidebar" class="fixed top-16 left-0 bottom-0 z-30 w-64 bg-surface-container-lowest border-r border-outline-variant/60 transition-transform duration-300 -translate-x-full lg:translate-x-0 overflow-y-auto">
    <div class="py-5 px-3 space-y-6">
        
        <!-- ============================================== -->
        <!-- ROLE: ADMINISTRATOR MENUS                      -->
        <!-- ============================================== -->
        @if ($activeRole === 'admin')
        <!-- Group: Navigasi Utama -->
        <div>
            <h6 class="px-3 text-[11px] font-bold text-outline uppercase tracking-wider mb-2">
                Menu Utama
            </h6>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin') ? 'bg-secondary text-white shadow-xs' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
                        <span class="material-symbols-outlined text-[20px]">dashboard</span>
                        <span>Dashboard Admin</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Group: Manajemen Pengguna & Tentor -->
        <div>
            <h6 class="px-3 text-[11px] font-bold text-outline uppercase tracking-wider mb-2">
                Pengguna &amp; Instruktur
            </h6>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('admin.users.*') ? 'bg-secondary text-white shadow-xs' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px]">group</span>
                            <span>Manajemen User</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.tentor.create') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('admin.tentor.*') ? 'bg-secondary text-white shadow-xs' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px]">person_add</span>
                            <span>Buat Akun Tentor</span>
                        </div>
                        <span class="text-[10px] font-bold bg-secondary-fixed text-on-secondary-fixed px-2 py-0.5 rounded-full">Khusus</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Group: Manajemen Pelatihan -->
        <div>
            <h6 class="px-3 text-[11px] font-bold text-outline uppercase tracking-wider mb-2">
                Manajemen Pelatihan
            </h6>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-secondary text-white shadow-xs' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px]">category</span>
                            <span>Kategori Pelatihan</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.trainings.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('admin.trainings.*') ? 'bg-secondary text-white shadow-xs' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px]">school</span>
                            <span>Daftar Pelatihan</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Group: Publikasi & Layanan Publik -->
        <div>
            <h6 class="px-3 text-[11px] font-bold text-outline uppercase tracking-wider mb-2">
                Konten &amp; Layanan
            </h6>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.posts.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('admin.posts.*') ? 'bg-secondary text-white shadow-xs' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.posts.*') ? 'text-white' : 'text-outline' }}">article</span>
                            <span>Berita &amp; Artikel</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-medium text-on-surface-variant hover:bg-surface-container-low hover:text-primary transition-all">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px] text-outline">mail</span>
                            <span>Pesan Kontak Masuk</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ============================================== -->
        <!-- ROLE: TENTOR / INSTRUKTUR MENUS               -->
        <!-- ============================================== -->
        @elseif ($activeRole === 'tentor')
        <div>
            <h6 class="px-3 text-[11px] font-bold text-outline uppercase tracking-wider mb-2">
                Instruktur Portal
            </h6>
            <ul class="space-y-1">
                <li>
                    <a href="{{ url('/tentor') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->is('tentor') ? 'bg-secondary text-white shadow-xs' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
                        <span class="material-symbols-outlined text-[20px]">dashboard</span>
                        <span>Dashboard Tentor</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/tentor') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-medium text-on-surface-variant hover:bg-surface-container-low hover:text-primary transition-all">
                        <span class="material-symbols-outlined text-[20px] text-outline">co_present</span>
                        <span>Pelatihan Ditugaskan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/tentor') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-medium text-on-surface-variant hover:bg-surface-container-low hover:text-primary transition-all">
                        <span class="material-symbols-outlined text-[20px] text-outline">menu_book</span>
                        <span>Kelola Modul Pembelajaran</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/tentor') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-medium text-on-surface-variant hover:bg-surface-container-low hover:text-primary transition-all">
                        <span class="material-symbols-outlined text-[20px] text-outline">badge</span>
                        <span>Profil &amp; Keahlian</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ============================================== -->
        <!-- ROLE: PESERTA PELATIHAN MENUS                 -->
        <!-- ============================================== -->
        @else
        <div>
            <h6 class="px-3 text-[11px] font-bold text-outline uppercase tracking-wider mb-2">
                Ruang Belajar Saya
            </h6>
            <ul class="space-y-1">
                <li>
                    <a href="{{ url('/peserta') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->is('peserta') ? 'bg-secondary text-white shadow-xs' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
                        <span class="material-symbols-outlined text-[20px]">school</span>
                        <span>Portal Peserta</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/peserta') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-medium text-on-surface-variant hover:bg-surface-container-low hover:text-primary transition-all">
                        <span class="material-symbols-outlined text-[20px] text-outline">book</span>
                        <span>Pelatihan Saya</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/agenda') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-medium text-on-surface-variant hover:bg-surface-container-low hover:text-primary transition-all">
                        <span class="material-symbols-outlined text-[20px] text-outline">explore</span>
                        <span>Telusuri Agenda Baru</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/peserta') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-medium text-on-surface-variant hover:bg-surface-container-low hover:text-primary transition-all">
                        <span class="material-symbols-outlined text-[20px] text-outline">person</span>
                        <span>Profil &amp; Akun</span>
                    </a>
                </li>
            </ul>
        </div>
        @endif

        <!-- Quick Back to Main Site -->
        <div class="pt-4 border-t border-outline-variant/40">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-medium text-outline hover:text-secondary transition-colors">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                <span>Kembali ke Beranda</span>
            </a>
        </div>

    </div>
</aside>
