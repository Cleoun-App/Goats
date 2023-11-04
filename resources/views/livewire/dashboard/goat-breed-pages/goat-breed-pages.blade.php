<div>

    <div class="intro-y box lg:mt-5">
        <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">
                {{ $page_title }}
            </h2>
            <!-- BEGIN: Modal Toggle -->
            <div class="text-center"> 
                <a href="javascript:;" data-toggle="modal" data-target="#form-add-breed"
                    class="btn btn-primary">Tambahkan Peranakan Kambing
                </a>
                <div>
                    <div id="form-add-breed" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- BEGIN: Modal Header -->
                                <div class="modal-header">
                                    <h2 class="font-medium text-base mr-auto">Form Tambah Peranakan</h2>
                                </div> <!-- END: Modal Header -->
                                <!-- BEGIN: Modal Body -->
                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                    <div class="col-span-12"> 
                                        <label for="role-name" class="form-label">Nama</label> 
                                        <input id="role-name" type="text" class="form-control" placeholder="..." wire:model.defer="breed_name">
                                        @error('breed_name')
                                            <div class="text-theme-21 mt-2">{{ $message }}</div>
                                        @enderror
                                     </div>
                                </div> <!-- END: Modal Body -->
                                <!-- BEGIN: Modal Footer -->
                                <div class="modal-footer text-right"> 
                                    <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Batal</button> 
                                    <button type="button" data-dismiss="modal" class="btn btn-primary w-25" wire:click="addBreed">Simpan</button> 
                                </div> <!-- END: Modal Footer -->
                            </div>
                        </div>
                    </div> 
                    
                </div>
            </div> 
            <!-- END: Modal Toggle -->
        </div>
        <div class="flex flex-col sm:flex-row sm:items-end xl:items-start p-5">
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
                {{-- @component('components.export-options', ['report_model' => 'breeds'])
                @endcomponent --}}
            </div>
        </div>
        <div class="overflow-x-auto scrollbar-hidden p-5">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr class="bg-gray-700 dark:bg-dark-1 text-white">
                            <th class="whitespace-nowrap">#</th>
                            <th class="whitespace-nowrap">Nama</th>
                            <th class="whitespace-nowrap">Slug</th>
                            <th class="whitespace-nowrap">Dibuat Pada</th>
                            <th class="whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($breeds as $breed)
                        
                            <tr>
                                <td class="border-b dark:border-dark-5">{{ $loop->index + 1 }}</td>
                                <td class="border-b dark:border-dark-5">{{ \Str::limit($breed->name, 15, '...') }}</td>
                                <td class="border-b dark:border-dark-5">{{ \Str::limit($breed->slug, 25, '...') ?? '-' }}</td>
                                <td class="border-b dark:border-dark-5">{{ $breed->created_at->format('d-m-Y') }}</td>
                                <td class="border-b dark:border-dark-5">
                                    <a class="btn btn-sm btn-primary" href="javacript:void(0)" data-toggle="modal"
                                        data-target="#show-modal-{{ $breed->id }}">SHow
                                    </a>
                                    <a class="btn btn-sm btn-danger" href="javacript:void(0)" data-toggle="modal"
                                        data-target="#delete-modal-{{ $breed->id }}">Hapus
                                    </a>
                                </td>
                            </tr>
                            
                            <!-- BEGIN: Modal Content -->

                            <div id="delete-modal-{{ $breed->id }}" class="modal" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body p-0">
                                            <div class="p-5 text-center">
                                                <i data-feather="x-circle"
                                                    class="w-16 h-16 text-theme-21 mx-auto mt-3"></i>
                                                <div class="text-3xl mt-5">Konfirmasi Penghapusan!!</div>
                                                <div class="text-gray-600 mt-2">Apakah anda ingin menghapus
                                                    Peranakan Kambing <br> '{{ $breed->name }}'
                                                    <br><strong style="color: rgba(242, 255, 61, 0.836)"> PERINGATAN <br> Data Yang Di Hapus Tidak Akan Bisa Dikembalikan!!</strong>
                                                </div>
                                            </div>
                                            <div class="px-5 pb-8 text-center">
                                                <button type="button" data-dismiss="modal"
                                                    class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">Batalkan
                                                </button>
                                                <button type="button" data-dismiss="modal" class="btn btn-danger w-24"
                                                    wire:click="deleteBreed({{ $breed->id }})">Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- END: Modal Content -->


                            <!-- BEGIN: Modal Content -->

                            <div id="show-modal-{{ $breed->id }}" class="modal" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- BEGIN: Modal Header -->
                                        <div class="modal-header">
                                            <h2 class="font-medium text-base mr-auto">Jenis Kambing</h2>
                                        </div> <!-- END: Modal Header -->
                                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                            <div class="col-span-12 ">
                                                <label class="form-label">Nama</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $breed->name }}" disabled>
                                            </div>
                                            <div class="col-span-12">
                                                <label class="form-label">Slug</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $breed->slug ?? '-' }}" disabled>
                                            </div>
                                        </div>
                                        <!-- END: Modal Body -->
                                        <!-- BEGIN: Modal Footer -->
                                        <div class="modal-footer text-right">
                                            <button type="button" data-dismiss="modal"
                                                class="btn btn-outline-secondary w-20 mr-1">Tutup</button>
                                        </div>
                                        <!-- END: Modal Footer -->

                                    </div>
                                </div>
                            </div>

                            <!-- END: Modal Content -->
                        @empty
                            <div class="alert alert-warning-soft show flex items-center mb-2" role="alert"> <i
                                    data-feather="alert-circle" class="w-6 h-6 mr-2"></i> Jenis kambing tidak tersedia!
                            </div>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @component('components.pagination-table-navigator', ['nav' => $breeds])
            @endcomponent

        </div>
    </div>

    
    @component('components.modal-loading-indicator')
    @endcomponent

</div>