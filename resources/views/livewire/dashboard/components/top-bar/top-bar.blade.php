<div class="top-bar -mx-4 px-4 md:mx-0 md:px-0">
    <!-- BEGIN: Breadcrumb -->
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex">

        @php
            $crumbs = session('app_breadcrumb', []);
        @endphp

        @foreach ($crumbs as $crumb)
            <a href="{{ $crumb['url'] }}" class="breadcrumb--active">{{$crumb['name']}}</a>
            <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        @endforeach
    </div>
    <!-- END: Breadcrumb -->
    
    
    <!-- BEGIN: Account Menu -->
    <div class="intro-x dropdown w-8 h-8">
        <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in" role="button"
            aria-expanded="false">
            <img alt="Tinker Tailwind HTML Admin Template" src="{{ $user->image() }}">
        </div>
        <div class="dropdown-menu w-56">
            <div class="dropdown-menu__content box dark:bg-dark-6">
                <div class="p-4 border-b border-black border-opacity-5 dark:border-dark-3">
                    <div class="font-medium">{{ $user->name }}</div>
                    <div class="text-xs text-gray-600 mt-0.5 dark:text-gray-600">{{ $user->email }}
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('ds.account_page') }}"
                        class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-gray-200 dark:hover:bg-dark-3 rounded-md">
                        <i data-feather="user" class="w-4 h-4 mr-2"></i> Profile </a>
                    <a href="{{ route('ds.account_page') }}?key=SC3RT2"
                        class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-gray-200 dark:hover:bg-dark-3 rounded-md">
                        <i data-feather="lock" class="w-4 h-4 mr-2"></i> Reset Password </a>
                </div>
                <div class="p-2 border-t border-black border-opacity-5 dark:border-dark-3">
                    <a href="{{ route('logout') }}"
                        class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-gray-200 dark:hover:bg-dark-3 rounded-md">
                        <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Account Menu -->
</div>
