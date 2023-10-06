<div>

    <div class="intro-y box lg:mt-5">
        <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">
                {{ $page_title }}
            </h2>
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
            <div class="flex mt-5 sm:mt-0">
                {{-- @component('components.export-options', ["username" => $username, 'report_model' => 'events'])
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
                            <th class="whitespace-nowrap">Tanggal Event</th>
                            <th class="whitespace-nowrap">Catatan</th>
                            <th class="whitespace-nowrap">Tipe</th>
                            <th class="whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($events as $xevent)
                            <tr>
                                <td class="border-b dark:border-dark-5">{{ $loop->index + 1 }}</td>
                                <td class="border-b dark:border-dark-5">{{ \Str::limit($xevent->name, 15, '...') }}</td>
                                <td class="border-b dark:border-dark-5">{{ $xevent->date->format('d-m-Y') }}</td>
                                <td class="border-b dark:border-dark-5">{{ \Str::limit($xevent->note, 25, '...') ?? '-' }}</td>
                                <td class="border-b dark:border-dark-5">{{ $xevent->type }}</td>
                                <td class="border-b dark:border-dark-5">
                                    <a class="btn btn-sm btn-primary" href="javacript:void(0)" data-toggle="modal"
                                        data-target="#show-modal-{{ $xevent->id }}">Show
                                    </a>
                                </td>
                            </tr>


                            <!-- BEGIN: Modal Content -->

                            <div id="show-modal-{{ $xevent->id }}" class="modal" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- BEGIN: Modal Header -->
                                        <div class="modal-header">
                                            <h2 class="font-medium text-base mr-auto">Data event peternakan</h2>
                                        </div> <!-- END: Modal Header -->
                                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                            <div class="col-span-12 sm:col-span-6">
                                                <label for="modal-form-1" class="form-label">Tanggal</label>
                                                <input id="modal-form-1" type="text" class="form-control"
                                                    value="{{ $xevent->date }}" disabled>
                                            </div>
                                            <div class="col-span-12 sm:col-span-6">
                                                <label class="form-label">Jenis Event</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $xevent->type }}" disabled>
                                            </div>
                                            <div class="col-span-12 sm:col-span-6">
                                                <label class="form-label">Cakupan</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $xevent->scope ?? '-' }}" disabled>
                                            </div>
                                            <div class="col-span-12 sm:col-span-6">
                                                <label class="form-label">~Kambing</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $xevent->goat?->name ?? '-' }}" disabled>
                                            </div>
                                            @foreach ($xevent->data as $kv => $e_data) 
                                                <div class="col-span-12">
                                                    <label class="form-label">{{ $kv }}</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $e_data ?? '-' }}" disabled>
                                                </div>
                                            @endforeach
                                            <div class="col-span-12">
                                                <label class="form-label">Catatan Farmer</label>
                                                <textarea class="form-control" width="100%" rows="5">{{ $xevent->note }}</textarea>
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
                                    data-feather="alert-circle" class="w-6 h-6 mr-2"></i> Event peternakan tidak ditemukan!
                            </div>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $events->links() }}

        </div>
        
    </div>

    
    @component('components.modal-loading-indicator')
    @endcomponent

</div>