<div>
    
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ $pageTitle }}
        </h2>
    </div>
    
    <!-- BEGIN: Profile Info -->
    <div class="intro-y box px-5 pt-5 mt-5">
        <div class="flex flex-col lg:flex-row border-b border-gray-200 dark:border-dark-5 pb-5 -mx-5">
            <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                    <img alt="Tinker Tailwind HTML Admin Template" class="rounded-full" src="{{ $user->image() }}">
                </div>
                <div class="ml-5">
                    <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{ $user->name  }}
                    </div>
                    <div class="text-gray-600">{{ $user->username }}</div>
                    <div style="mt-3">
                        <span class=" rounded-full bg-theme-25 text-white" style="font-size: 10px; padding: 1.3px 9px; text-transform: capitalize">{{ $user->roles[0]->name }}</span>
                    </div>
                </div>
            </div>
            <div
                class="mt-6 lg:mt-0 flex-1 dark:text-gray-300 px-5 border-l border-r border-gray-200 dark:border-dark-5 border-t lg:border-t-0 pt-5 lg:pt-0">
                <div class="font-medium text-center lg:text-left lg:mt-3">Contact Details</div>
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    @foreach ($user->getContacts() as $key => $contact)
                        @if ($contact !== "")
                            <div class="truncate sm:whitespace-normal flex items-center"> 
                                <i data-feather="{{$key}}"
                                class="w-4 h-4 mr-2"></i> 
                                <span style="text-align: justify">{{$key}} 
                                    <strong>{{ $contact }}</strong>
                                </span> 
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div
                class="mt-6 lg:mt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-0 border-gray-200 dark:border-dark-5 pt-5 lg:pt-0">
                <div class="text-center rounded-md w-20 py-3">
                    <div class="font-medium text-theme-25 dark:text-theme-22 text-xl">{{ count($posts) }}</div>
                    <div class="text-gray-600">Postingan</div>
                </div>
                {{-- <div class="text-center rounded-md w-20 py-3">
                    <div class="font-medium text-theme-25 dark:text-theme-22 text-xl">{{ count($invitations) }}</div>
                    <div class="text-gray-600">Undangan</div>
                </div> --}}
            </div>
        </div>
        <div class="nav nav-tabs flex-col sm:flex-row justify-center lg:justify-start" role="tablist">
            @foreach ($pages as $menu_page)
                <button style="outline: none"
                class="py-4 sm:mr-8 flex items-center @if($act_page === $menu_page['key']) active @endif " wire:click="pergi('{{ $menu_page['key'] }}')">
                    <i class="w-4 h-4 mr-2" data-feather="{{ $menu_page['icon'] }}"></i> {{ $menu_page['name'] }} 
                </button>
            @endforeach
        </div>
    </div>
    <!-- END: Profile Info -->
    <div class="tab-content mt-5">
        @foreach ($pages as $page)
            @if ($page['key'] === $act_page)
                @livewire($page['path'], ['posts' => $posts, 'username' => $username], key($act_page))
            @endif
        @endforeach
    </div>
    <!-- End: Content Page -->

</div>