<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ auth_user()->visualMode() }}" style="transition: all 19s">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $pageTitle ?? config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    @livewireStyles
    @livewireScripts

    <!-- Include Choices CSS -->
    <link rel="stylesheet" href="/assets/libs/choices/ch.min.css" />


    <!-- Include Choices JavaScript (latest) -->
    <script src="/assets/libs/choices/ch.min.js"></script>

    <link rel="stylesheet" href="/assets/core/css/app.css" fetchpriority="high" />

    <link rel="stylesheet" href="/assets/core/css/iziToast.min.css" fetchpriority="high" />
    <link rel="stylesheet" href="/css/style.css">

    <script src="/assets/core/js/iziToast.min.js"></script>

    {{-- deps --}}
    <link rel="stylesheet" href="/assets/libs/filepond/filepond.css">
    <script src="/assets/libs/filepond/filepond.js"></script>

    
    <style>
        .bx-form-file .bx-field {
            position: relative;
        }

        .bx-form-file .bx-field input {
            display: inline-block;
            width: 80%;
        }

        .bx-form-file .bx-field .btn {
            margin-left: 10px;
        }
        
        .d-none {
            display: none;
            visibility: hidden;
        }

        *{
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif
        }

        .modal.show {
            z-index: 10000;
        }
    </style>


    <style>
        nav > div.hidden > div:nth-child(1) .leading-5 {
            display: none;
        }

        nav > div.hidden > div:nth-child(2) button {
            background-color: #293145;
            color: whitesmoke;
        }
        
        nav > div.hidden > div:nth-child(2) span[aria-current="page"] > span {
            color: #21283a;
            background-color: #ebebeb;
        }
    </style>

</head>

<body class="main font-sans antialiased">

    <!-- BEGIN: Mobile Menu -->
    @livewire('dashboard.components.mobile-menu.mobile-menu', [], key(rand(99, 9999)))
    <!-- END: Mobile Menu -->

    <div class="flex overflow-hidden">

        <!-- BEGIN: Side Menu -->
        @livewire('dashboard.components.side-menu.side-menu', [], key(rand(1, 9999)))
        <!-- END: Side Menu -->


        <div class="content content--dashboard">

            <!-- BEGIN: Top Bar -->
            @livewire('dashboard.components.top-bar.top-bar', [], key(rand(1, 9999)))
            <!-- END: Top Bar -->

            <!-- Start: Content Page -->

            {{ $slot }}

            <!-- End: Content Page -->

        </div>


    </div>



    <!-- BEGIN: Dark Mode Switcher-->
    {{-- <div data-url="?mode=dark" class="dark-mode-switcher cursor-pointer shadow-md fixed bottom-0 right-0 box dark:bg-dark-2 border rounded-full w-40 h-12 flex items-center justify-center z-50 mb-10 mr-10">
        <div class="mr-4 text-gray-700 dark:text-gray-300">Dark Mode</div>
        <div class="dark-mode-switcher__toggle border"></div>
    </div> --}}
    <!-- END: Dark Mode Switcher-->
    <!-- BEGIN: JS Assets-->
    <script src="/assets/libs/mkcluster/mks.js">
    </script>
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=[" your-google-map-api"]&libraries=places"></script> -->
    <!-- END: JS Assets-->


    @stack('modals')


    <!-- Scripts -->
    
    <script src="/assets/core/js/app.js"></script>
    
    <script src="/assets/libs/tabulator/js/tabulator.min.js"></script>
    
    <script src="/js/app.js"></script>
    
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
    
    {{-- turbolinks --}}
    {{-- <script src="/assets/js/turbolinks.js"></script>
    <script src="/assets/js/turbolinks-adapter.js"></script> --}}

</body>

</html>