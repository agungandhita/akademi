@include('admin.partials.start')

@include('admin.partials.header')

@include('admin.partials.sidebar')

<div id="main-content" class="min-h-screen pt-16 lg:pl-64 flex flex-col justify-between transition-all duration-300 bg-surface">
    <main class="p-4 sm:p-6 lg:p-8 flex-grow">
        @yield('container')
    </main>

    <!-- Admin & Dashboard Footer -->
    <footer class="bg-surface-container-lowest border-t border-outline-variant/60 py-4 px-6 text-xs text-on-surface-variant flex flex-col sm:flex-row items-center justify-between gap-2">
        <span class="font-medium">&copy; {{ date('Y') }} Akademi Pelatihan — Portal Pembelajaran &amp; Manajemen Terpadu.</span>
        <span class="text-outline font-semibold">Standar Kualitas Nasional Indonesia</span>
    </footer>
</div>

@include('admin.partials.norifikasi')
@include('sweetalert::alert')
@include('admin.partials.end')
