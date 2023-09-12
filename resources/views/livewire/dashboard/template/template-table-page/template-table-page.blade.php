<div>


    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Table Templates
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <div class="dropdown ml-auto sm:ml-0">
                <button class="dropdown-toggle btn px-2 box text-gray-700 dark:text-gray-300" aria-expanded="false">
                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="plus"></i>
                    </span>
                </button>
                <div class="dropdown-menu w-40">
                    <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                        <a href="{{ route('template.add') }}"
                            class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                            <i data-feather="file-plus" class="w-4 h-4 mr-2"></i> Buat Template </a>
                    </div>
                </div>
            </div>
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
                                    
                        <div wire:target="$refresh" wire:loading.flex style="justify-content: center; align-items: center; margin: 0px; padding: 5px 0px">
                            <svg width="25" viewBox="0 0 120 30" xmlns="http://www.w3.org/2000/svg" fill="rgb(226, 232, 240)" class="w-8 h-7">
                                <circle cx="15" cy="15" r="15">
                                    <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate>
                                    <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate>
                                </circle>
                                <circle cx="60" cy="15" r="9" fill-opacity="0.3">
                                    <animate attributeName="r" from="9" to="9" begin="0s" dur="0.8s" values="9;15;9" calcMode="linear" repeatCount="indefinite"></animate>
                                    <animate attributeName="fill-opacity" from="0.5" to="0.5" begin="0s" dur="0.8s" values=".5;1;.5" calcMode="linear" repeatCount="indefinite"></animate>
                                </circle>
                                <circle cx="105" cy="15" r="15">
                                    <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate>
                                    <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate>
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
                    <button class="dropdown-toggle btn btn-outline-secondary w-full sm:w-auto" aria-expanded="false"> <i
                            data-feather="file-text" class="w-4 h-4 mr-2"></i> Export <i data-feather="chevron-down"
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
                            <th class="whitespace-nowrap">Slug</th>
                            <th class="whitespace-nowrap">Harga</th>
                            <th class="whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($templates as $template)
                            <tr>
                                <td class="border-b dark:border-dark-5">{{ $loop->index + 1 }}</td>
                                <td class="border-b dark:border-dark-5">{{ $template->name }}</td>
                                <td class="border-b dark:border-dark-5">{{ $template->slug }}</td>
                                <td class="border-b dark:border-dark-5">{{ $template->readablePrice() }}</td>
                                <td class="border-b dark:border-dark-5">
                                    <a href="{{ route('template.edit', $template->slug) }}" class="btn btn-sm btn-success mr-1">Ubah</a >
                                    <form action="" method="post" style="display: inline-block">
                                        @method('delete')
                                        <button class="btn btn-sm btn-danger" type="submit"
                                            onclick="return confirm('Konfirmasi penghapusan template!!')">Hapus
                                        </button>
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <div class="alert alert-warning-soft show flex items-center mb-2 mt-5" role="alert"> <i
                                    data-feather="alert-circle" class="w-6 h-6 mr-2"></i> Template Tidak Di-temukan!!
                            </div>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $templates->links('vendor.pagination.default') }}

        </div>

    </div>
    <!-- END: HTML Table Data -->

</div>
