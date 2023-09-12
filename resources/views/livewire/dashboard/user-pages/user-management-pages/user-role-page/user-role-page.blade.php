<div>


    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ $pageTitle }}
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <!-- BEGIN: Modal Toggle -->
            <div class="text-center"> 
                <a href="javascript:;" data-toggle="modal" data-target="#form-add-role"
                    class="btn btn-primary">Tambahkan Role
                </a>
                @livewire('dashboard.user-pages.user-management-pages.user-role-page.components.form-dialog', [
                    'id_modal' => 'form-add-role', 
                    'title' => 'Tambahkan Role',
                ], key('1029192u9a0s'))
            </div> <!-- END: Modal Toggle -->
            
        </div>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
            <form id="tabulator-html-filter-form" class="xl:flex sm:mr-auto">
                <div class="sm:flex items-center sm:mr-4">
                    <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Field</label>
                    <select id="tabulator-html-filter-field"
                        class="form-select w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto"
                        wire:model.defer="search_field">
                        @foreach ($searchable_fields as $field)
                            @if ($search_field === $field[0])
                                <option value="{{ $field[0] }}" selected>
                                    {{ $field[1] }}</option>
                            @else
                                <option value="{{ $field[0] }}">
                                    {{ $field[1] }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                    <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Tipe</label>
                    <select id="tabulator-html-filter-type" class="form-select w-full mt-2 sm:mt-0 sm:w-auto"
                        wire:model.defer="search_operator">
                        @foreach ($search_operators as $opr)
                            @if ($search_operator === $opr[0])
                                <option value="{{ $opr[0] }}" selected>
                                    {{ $opr[1] }}</option>
                            @else
                                <option value="{{ $opr[0] }}">
                                    {{ $opr[1] }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                    <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Nilai</label>
                    <input id="tabulator-html-filter-value" type="text"
                        class="form-control sm:w-40 xxl:w-full mt-2 sm:mt-0" placeholder="Search..."
                        wire:model.defer="search_value">
                </div>
                <div class="mt-2 xl:mt-0">
                    <button id="tabulator-html-filter-go" type="button" class="btn btn-primary w-full sm:w-16"
                        wire:click="$refresh" wire:loading.attr="disabled">
                        <span wire:target="$refresh" wire:loading.remove>Cari</span>

                        <div wire:target="$refresh" wire:loading.flex
                            style="justify-content: center; align-items: center; margin: 0px; padding: 5px 0px">
                            <svg width="25" viewBox="0 0 120 30" xmlns="http://www.w3.org/2000/svg"
                                fill="rgb(226, 232, 240)" class="w-8 h-7">
                                <circle cx="15" cy="15" r="15">
                                    <animate attributeName="r" from="15" to="15" begin="0s"
                                        dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite">
                                    </animate>
                                    <animate attributeName="fill-opacity" from="1" to="1"
                                        begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear"
                                        repeatCount="indefinite"></animate>
                                </circle>
                                <circle cx="60" cy="15" r="9" fill-opacity="0.3">
                                    <animate attributeName="r" from="9" to="9" begin="0s"
                                        dur="0.8s" values="9;15;9" calcMode="linear" repeatCount="indefinite">
                                    </animate>
                                    <animate attributeName="fill-opacity" from="0.5" to="0.5"
                                        begin="0s" dur="0.8s" values=".5;1;.5" calcMode="linear"
                                        repeatCount="indefinite"></animate>
                                </circle>
                                <circle cx="105" cy="15" r="15">
                                    <animate attributeName="r" from="15" to="15" begin="0s"
                                        dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite">
                                    </animate>
                                    <animate attributeName="fill-opacity" from="1" to="1"
                                        begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear"
                                        repeatCount="indefinite"></animate>
                                </circle>
                            </svg>
                        </div>
                    </button>
                    <button id="tabulator-html-filter-reset" wire:click="$set('search_value', null)" type="button"
                        class="btn btn-secondary w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1">Ulang</button>
                </div>
            </form>
            <div class="flex mt-5 sm:mt-0 d-none">
                <button id="tabulator-print" class="btn btn-outline-secondary w-1/2 sm:w-auto mr-2"> <i
                        data-feather="printer" class="w-4 h-4 mr-2"></i> Print </button>
                <div class="dropdown w-1/2 sm:w-auto">
                    <button class="dropdown-toggle btn btn-outline-secondary w-full sm:w-auto" aria-expanded="false">
                        <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export <i data-feather="chevron-down"
                            class="w-4 h-4 ml-auto sm:ml-2"></i> </button>
                    <div class="dropdown-menu w-40">
                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                            <a id="tabulator-export-csv" href="javascript:;"
                                class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export CSV </a>
                            <a id="tabulator-export-json" href="javascript:;"
                                class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export JSON </a>
                            <a id="tabulator-export-xlsx" href="javascript:;"
                                class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export XLSX </a>
                            <a id="tabulator-export-html" href="javascript:;"
                                class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export HTML </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto scrollbar-hidden">
            <div class="overflow-x-auto">
                <table class="table mt-5">
                    <thead>
                        <tr class="bg-gray-700 dark:bg-dark-1 text-white">
                            <th class="whitespace-nowrap">#</th>
                            <th class="whitespace-nowrap">Nama</th>
                            <th class="whitespace-nowrap">Guard</th>
                            <th class="whitespace-nowrap">Created</th>
                            <th class="whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $usx)
                            <tr>
                                <td class="border-b dark:border-dark-5">{{ $loop->index + 1 }}</td>
                                <td class="border-b dark:border-dark-5">{{ $usx->name }}</td>
                                <td class="border-b dark:border-dark-5">{{ $usx->guard_name }}</td>
                                <td class="border-b dark:border-dark-5">{{ $usx->created_at->format('D d, M Y') }}
                                </td>
                                <td class="border-b dark:border-dark-5">
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#edit-role-{{ $loop->index }}"
                                        class="btn btn-sm btn-primary mr-1">Ubah
                                    </a>
                                    <a class="btn btn-sm btn-danger" href="javacript:void(0)" data-toggle="modal"
                                        data-target="#delete-modal-{{ $usx->id }}">Hapus
                                    </a>
                                </td>

                            <!-- BEGIN: Modal Content -->

                            <div id="delete-modal-{{ $usx->id }}" class="modal" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body p-0">
                                            <div class="p-5 text-center">
                                                <i data-feather="x-circle"
                                                    class="w-16 h-16 text-theme-21 mx-auto mt-3"></i>
                                                <div class="text-3xl mt-5">Konfirmasi Penghapusan!!</div>
                                                <div class="text-gray-600 mt-2">Apakah anda ingin menghapus
                                                    Role Pengguna <br> '{{ $usx->name }}'
                                                    <br><strong style="color: rgba(242, 255, 61, 0.836)"> PERINGATAN <br> Data Yang Di Hapus Tidak Akan Bisa Dikembalikan!!</strong>
                                                </div>
                                            </div>
                                            <div class="px-5 pb-8 text-center">
                                                <button type="button" data-dismiss="modal"
                                                    class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">Batalkan
                                                </button>
                                                <button type="button" data-dismiss="modal" class="btn btn-danger w-24"
                                                    wire:click="deleteRole({{ $usx->id }})">Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- END: Modal Content -->
                                
                                @livewire('dashboard.user-pages.user-management-pages.user-role-page.components.form-dialog', [
                                    'id_modal' => 'edit-role-' . $loop->index,
                                    'title' => 'Edit Role',
                                    'role_id' => $usx->id,
                                ], key($usx->id))
                            </tr>
                        @empty
                            <div class="alert alert-warning-soft show flex items-center mb-2 mt-5" role="alert"> <i
                                    data-feather="alert-circle" class="w-6 h-6 mr-2"></i> Pengguna Tidak Di-temukan!!
                            </div>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $roles->links('vendor.pagination.default', ['psize' => $page_size]) }}

        </div>

    </div>
    <!-- END: HTML Table Data -->

</div>
