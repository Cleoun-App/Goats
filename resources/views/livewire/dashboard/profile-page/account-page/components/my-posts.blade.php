<div id="profile" class="tab-pane active" role="tabpanel" aria-labelledby="profile-tab">
    <div class="grid grid-cols-12 gap-6">
        <!-- BEGIN: Latest Uploads -->
        <div class="intro-y box col-span-12">
            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Postingan Saya
                </h2>
                <div class="dropdown ml-auto sm:hidden">
                    <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false"> <i
                            data-feather="more-horizontal" class="w-5 h-5 text-gray-600 dark:text-gray-300"></i>
                    </a>
                    <div class="dropdown-menu w-40">
                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2"> <a href="javascript:;"
                                class="block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">All
                                Files</a> </div>
                    </div>
                </div>
                <button class="btn btn-outline-success hidden sm:flex">Tambah</button>
                @if (count($posts) >= 1)
                    <button class="btn btn-outline-secondary hidden sm:flex ml-2">Semua</button>
                @endif
            </div>
            <div class="p-5">

                    
                @forelse ($posts as $post)
                    <div class="flex items-center">
                        <div class="file w-12 h-12 flex-none image-fit">
                            <img alt="Tinker Tailwind HTML Admin Template" class="rounded-full"
                                src="/assets/core/images/profile-15.jpg">
                        </div>

                        <div class="ml-4">
                            <a class="font-medium" href="">Eviantix Iv</a>
                            <div class="text-gray-600 text-xs mt-0.5">40 KB</div>
                        </div>
                        <div class="dropdown ml-auto">
                            <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false"> <i
                                    data-feather="more-horizontal"
                                    class="w-5 h-5 text-gray-600 dark:text-gray-300"></i> </a>
                            <div class="dropdown-menu w-40">
                                <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                    <a href=""
                                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                        <i data-feather="users" class="w-4 h-4 mr-2"></i> Share File </a>
                                    <a href=""
                                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                        <i data-feather="trash" class="w-4 h-4 mr-2"></i> Delete </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty

                    <div class="alert alert-warning-soft show flex items-center mb-2" role="alert"> <i data-feather="alert-triangle" class="w-6 h-6 mr-2"></i> <span class="mr-2">Anda belum memiliki sebuah </span>  <strong>Postingan!!</strong></div>

                @endforelse

            </div>
        </div>
        <!-- END: Latest Uploads -->
    </div>
</div>