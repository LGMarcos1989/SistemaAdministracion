<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
    @stack('css')
</head>

<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('layouts.header')

            <main class="flex-1 overflow-y-auto p-4 md:p-6">
                @yield('section')
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    @vite('resources/js/app.js')
    @stack('js')

    
   @if (session('flash'))
        <script>
            window.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: @json(session('flash.title')),
                    icon: @json(session('flash.icon')),
                });
            })
        </script>
    @endif
</body>

</html>
