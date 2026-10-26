@include('frontend.partials.start')
@include('frontend.partials.navbar')

<main class="flex-grow">
    @yield('container')
</main>

@include('frontend.partials.footer')
@include('sweetalert::alert')
@include('frontend.partials.end')
