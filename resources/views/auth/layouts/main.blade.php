@include('auth.partials.head')

<div class="min-h-screen flex flex-col justify-center">
    @yield('container')
</div>

@include('sweetalert::alert')
@include('auth.partials.end')
