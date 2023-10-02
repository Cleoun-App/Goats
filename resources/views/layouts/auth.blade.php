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

    <link rel="stylesheet" href="/assets/core/css/app.css" fetchpriority="high" />

    <link rel="stylesheet" href="/css/style.css">

    {{-- laravel core --}}
    <script src="/js/app.js" defer></script>

    {{-- web core --}}
    <script src="/assets/core/js/app.js" defer></script>
    
    <script src="/assets/core/js/iziToast.min.js"></script>
    
    <link rel="stylesheet" href="/assets/core/css/iziToast.min.css" fetchpriority="high" />



</head>

<body class="login">

    {{ $slot }}

       
    <script src="/assets/core/js/app.js"></script>
    
    <script src="/assets/libs/tabulator/js/tabulator.min.js"></script>
    
    <script>
        slx_init();
    </script>

    
    <script>
                                    
        function bxupload(element) {
            let formField = element.parentElement.parentElement;
            let inputFile = formField.lastElementChild;

            inputFile.click();
        }

        let bxfilechange = (element, event) => {
            let file = element.files[0];
            let placeholder = element.parentElement.getElementsByClassName('bx-field')[0].firstElementChild;
            placeholder.value = file.name;
        }

    </script>

</body>

</html>
