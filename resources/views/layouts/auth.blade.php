<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @livewireStyles
    @livewireScripts

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <link rel="stylesheet" href="/assets/core/css/app.css" />

    {{-- laravel core --}}
    <script src="/js/app.js" defer></script>

    {{-- web core --}}
    <script src="/assets/core/js/app.js" defer></script>

    
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            Livewire.hook('element.initialized', (el, component) => {
                feather.replace();
            })
        });
        window.addEventListener('app.flash.notif', function(event) {
            if (event.detail.type === 'success')
                iziToast.success({
                    title: event.detail.title,
                    message: event.detail.message,
                    timeout: event.detail.timeout,
                });

            if (event.detail.type === 'info')
                iziToast.info({
                    title: event.detail.title,
                    message: event.detail.message,
                    timeout: event.detail.timeout,
                });

            if (event.detail.type === 'error')
                iziToast.error({
                    title: event.detail.title,
                    message: event.detail.message,
                    timeout: event.detail.timeout,
                });

            if (event.detail.type === 'warning')
                iziToast.warning({
                    title: event.detail.title,
                    message: event.detail.message,
                    timeout: event.detail.timeout,
                });
        });
    </script>

</head>

<body class="login">

    {{ $slot }}

</body>

</html>
