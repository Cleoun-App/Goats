<div>

    <div class="grid grid-cols-12 gap-6 mt-8">

        <div class="col-span-12 lg:col-span-9 xxl:col-span-10">
            <h2 class="intro-y text-lg font-medium mr-auto mt-2">
                {{ $page_title }}
            </h2>
            <!-- BEGIN: Inbox Filter -->
            <div class="intro-y mt-2 flex flex-col-reverse sm:flex-row items-center">
                <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 ml-3 left-0 z-10 text-gray-700 dark:text-gray-300"
                        data-feather="search"></i>
                    <input type="text"
                        class="form-control w-full sm:w-64 box px-10 text-gray-700 dark:text-gray-300 placeholder-theme-13"
                        placeholder="Temukan Notifikasi" wire:model.lazy="search">
                </div>
                <div class="w-full sm:w-auto flex">
                    {{-- <button class="btn btn-primary shadow-md mr-2">Start a Video Call</button> --}}
                    <div class="dropdown">
                        <button class="dropdown-toggle btn px-2 box text-gray-700 dark:text-gray-300"
                            aria-expanded="false">
                            <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4"
                                    data-feather="settings"></i> </span>
                        </button>
                        <div class="dropdown-menu w-40">
                            <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                <a href=""
                                    class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                    <i data-feather="user" class="w-4 h-4 mr-2"></i> Hapus </a>
                                <a href=""
                                    class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                    <i data-feather="settings" class="w-4 h-4 mr-2"></i> Settings </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Inbox Filter -->
            <!-- BEGIN: Inbox Content -->
            <div class="intro-y inbox box mt-5">
                <div
                    class="p-5 flex flex-col-reverse sm:flex-row text-gray-600 border-b border-gray-200 dark:border-dark-1">
                    <div
                        class="flex items-center mt-3 sm:mt-0 border-t sm:border-0 border-gray-200 pt-5 sm:pt-0 mt-5 sm:mt-0 -mx-5 sm:mx-0 px-5 sm:px-0">
                        <input class="form-check-input" type="checkbox">
                        <div class="dropdown ml-1" data-placement="bottom-start">
                            <a class="dropdown-toggle w-5 h-5 block dark:text-gray-300" href="javascript:;"
                                aria-expanded="false"> <i data-feather="chevron-down" class="w-5 h-5"></i> </a>
                            <div class="dropdown-menu w-32">
                                <div class="dropdown-menu__content box dark:bg-dark-1 p-2"> <a href=""
                                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">All</a>
                                    <a href=""
                                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">None</a>
                                    <a href=""
                                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Read</a>
                                    <a href=""
                                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Unread</a>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:;" wire:click="freshUp" wire:loading.class="d-none"
                            class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300">
                            <i class="w-4 h-4" data-feather="refresh-cw"></i>
                        </a>
                        <span class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300 d-none"
                            wire:loading.class.remove='d-none'>
                            <svg width="30" viewBox="0 0 45 45" xmlns="http://www.w3.org/2000/svg"
                                stroke="rgb(226, 232, 240)" class="w-8 h-8">
                                <g fill="none" fill-rule="evenodd" transform="translate(1 1)" stroke-width="3">
                                    <circle cx="22" cy="22" r="6" stroke-opacity="0">
                                        <animate attributeName="r" begin="1.5s" dur="3s" values="6;22"
                                            calcMode="linear" repeatCount="indefinite"></animate>
                                        <animate attributeName="stroke-opacity" begin="1.5s" dur="3s"
                                            values="1;0" calcMode="linear" repeatCount="indefinite"></animate>
                                        <animate attributeName="stroke-width" begin="1.5s" dur="3s"
                                            values="2;0" calcMode="linear" repeatCount="indefinite"></animate>
                                    </circle>
                                    <circle cx="22" cy="22" r="6" stroke-opacity="0">
                                        <animate attributeName="r" begin="3s" dur="3s" values="6;22"
                                            calcMode="linear" repeatCount="indefinite"></animate>
                                        <animate attributeName="stroke-opacity" begin="3s" dur="3s"
                                            values="1;0" calcMode="linear" repeatCount="indefinite"></animate>
                                        <animate attributeName="stroke-width" begin="3s" dur="3s"
                                            values="2;0" calcMode="linear" repeatCount="indefinite"></animate>
                                    </circle>
                                    <circle cx="22" cy="22" r="8">
                                        <animate attributeName="r" begin="0s" dur="1.5s"
                                            values="6;1;2;3;4;5;6" calcMode="linear" repeatCount="indefinite">
                                        </animate>
                                    </circle>
                                </g>
                            </svg>
                        </span>
                    </div>
                    <div class="flex items-center sm:ml-auto">
                        <div class="dark:text-gray-300">Unread {{ $c_new }} / {{ $c_inbox }}</div>
                    </div>
                </div>
                <div class="overflow-x-auto sm:overflow-x-visible">

                    <div wire:loading.class.remove="d-none"
                        class="alert alert-primary-soft show flex items-center d-none" style="margin: 10px"
                        role="alert">
                        Loading...
                    </div>

                    @forelse ($notifs as $notif)
                        @php
                            $data = $notif->data;
                            $notif->markAsRead();
                        @endphp
                        <div class="intro-y">
                            <div
                                class="inbox__item inbox__item--active inline-block sm:block text-gray-700 dark:text-gray-500 bg-gray-100 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1">
                                <div class="flex px-5 py-3">
                                    <div class="w-72 flex-none flex items-center mr-5">
                                        <input class="form-check-input flex-none" type="checkbox">
                                        <div class="inbox__item--sender truncate ml-3">{{ $data['title'] }}</div>
                                    </div>
                                    <div class="w-64 sm:w-auto truncate"> <span
                                            class="inbox__item--highlight">{{ \Str::limit($data['message'], 50, '...') }}</span>
                                    </div>
                                    <div class="inbox__item--time whitespace-nowrap ml-auto pl-10">
                                        {{ $notif->created_at->diffForHumans() }}</div>
                                    <div class="inbox__item--time whitespace-nowrap pl-10">
                                        <a class="btn btn-sm btn-primary mr-1" href="javascript:void(0)"
                                            data-toggle="modal" data-target="#show-modal-{{ $notif->id }}">
                                            <i data-feather="message-circle" class="w-4 h-4"></i>
                                        </a>
                                        <a class="btn btn-sm btn-danger mr-1" href="javascript:void(0)"
                                            data-toggle="modal" data-target="#delete-modal-{{ $notif->id }}">
                                            <i data-feather="trash" class="w-4 h-4"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- BEGIN: Modal Content -->
                        <div id="show-modal-{{ $notif->id }}" class="modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <!-- BEGIN: Modal Header -->
                                    <div class="modal-header">
                                        <h2 class="font-medium text-base mr-auto">Detail Notifikasi</h2>
                                    </div>
                                    <!-- END: Modal Header -->
                                    <!-- BEGIN: Modal Body -->
                                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                        <div class="col-span-12">
                                            <label  class="form-label">Title</label>
                                            <input type="text" class="form-control disabled" disabled value="{{ $data['title'] }}">
                                        </div>
                                        <div class="col-span-12" style="position: relative">
                                            <label class="form-label">Message</label>
                                            <textarea class="form-control disabled" style="width: 100%; min-height: 20%;">
{{ $data['message'] }} </textarea>
                                        </div>
                                    </div>
                                    <!-- END: Modal Body -->
                                    <!-- BEGIN: Modal Footer -->
                                    <div class="modal-footer text-right"> 
                                        <button type="button" data-dismiss="modal"
                                            class="btn btn-outline-secondary w-20 mr-1">Tutup
                                        </button> 
                                    </div>
                                    <!-- END: Modal Footer -->
                                </div>
                            </div>
                        </div>
                        <!-- END: Modal Content -->


                        <!-- BEGIN: Modal Content -->

                        <div id="delete-modal-{{ $notif->id }}" class="modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <div class="p-5 text-center">
                                            <i data-feather="x-circle"
                                                class="w-16 h-16 text-theme-21 mx-auto mt-3"></i>
                                            <div class="text-3xl mt-5">Konfirmasi Penghapusan!!</div>
                                            <div class="text-gray-600 mt-2">Apakah anda yakin ingin menghapus
                                                notifikasi ini
                                                <br> <strong style="color: rgba(242, 255, 61, 0.836)"> PERINGATAN <br>
                                                    Data Yang Di Hapus Tidak Akan Bisa Dikembalikan!!</strong>
                                            </div>
                                        </div>
                                        <div class="px-5 pb-8 text-center">
                                            <button type="button" data-dismiss="modal"
                                                class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">Batalkan
                                            </button>
                                            <button wire:key="xnxx-{{ $notif->id }}" type="button"
                                                data-dismiss="modal" class="btn btn-danger w-24"
                                                wire:click="dlx('{{ $notif->id }}')">Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- END: Modal Content -->
                    @empty
                        <div wire:loading.class="d-none" wire:key="uixoa"
                            class="alert alert-warning-soft show flex items-center" style="margin: 10px"
                            role="alert"> <i data-feather="alert-circle" class="w-6 h-6 mr-2"></i> Tidak Ada
                            Notifikasi Yang Tersedia </div>
                    @endforelse


                </div>
                <div class="p-5 flex flex-col sm:flex-row items-center text-center sm:text-left text-gray-600">
                    {{ $notifs?->links('vendor.pagination.default', ['psize' => 0]) }}
                </div>
            </div>
            <!-- END: Inbox Content -->
        </div>

        <div class="col-span-12 lg:col-span-3 xxl:col-span-2">
            <!-- BEGIN: Inbox Menu -->
            <div class="intro-y box bg-theme-1 p-5 mt-6">
                <div class="dark:border-dark-5 mt-2  text-white">
                    @foreach ($section_pages as $spage)
                        @php
                            $kyx = 'c_' . $spage['key'];
                        @endphp
                        @if ($spage['key'] === $active_section)
                            <a href="javascript: void(0)"
                                class="flex items-center px-3 py-2 mt-2 rounded-md bg-theme-25 dark:bg-dark-1 font-medium">
                                <i class="w-4 h-4 mr-2" data-feather="{{ $spage['icon'] }}"></i>
                                {{ $spage['name'] }}
                            </a>
                        @else
                            <a href="?active_section={{ $spage['key'] }}"
                                class="flex items-center px-3 py-2 mt-2 rounded-md">
                                <i class="w-4 h-4 mr-2" data-feather="{{ $spage['icon'] }}">
                                </i>
                                {{ $spage['name'] }} ({{ "${$kyx}" }})
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
            <!-- END: Inbox Menu -->
        </div>
    </div>

</div>
