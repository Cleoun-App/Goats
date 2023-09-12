<div>
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                Edit Template
            </h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <a href="/preview_template.php" type="button" class="btn box text-gray-700 dark:text-gray-300 mr-2 flex items-center ml-auto sm:ml-0"> <i class="w-4 h-4 mr-2" data-feather="eye"></i> Preview </a>
                <button wire:click="save" wire:loading.attr="disabled" class="btn btn-primary shadow-md flex items-center" aria-expanded="false">
                    <span wire:loading.remove wire:target="save"><i class="w-4 h-4 mr-2" data-feather="save"></i> Save</span>
                                    
                    <div wire:loading.flex wire:target="save" style="justify-content: center; align-items: center; margin: 0px; padding: 5px 0px">
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
            </div>
        </div>
        <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
            <!-- BEGIN: Post Content -->
            <div class="intro-y col-span-12 lg:col-span-8">
                {{-- <input type="text" class="intro-y form-control py-3 px-4 box pr-10 placeholder-theme-13" placeholder="Nama Template"> --}}
                <div class="post intro-y overflow-hidden box ------mt-5">
                    <div class="post__content tab-content">
                        <div id="content" class="tab-pane p-5 active" role="tabpanel" aria-labelledby="content-tab">

                            <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5 mt-5">
                                <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5"> <i data-feather="chevron-down" class="w-4 h-4 mr-2"></i> Informasi Template </div>
                                <div class="mt-5">

                                    <div>
                                        <label for="name-field" class="form-label">Nama</label>
                                        <input id="name-field" type="text" class="form-control" placeholder="Nama" wire:model="name">
                                    </div>
                                    @error('name')
                                    <div class="text-theme-21 mt-2">{{ $message }}</div>
                                    @enderror

                                    <div class="mt-3">
                                        <label for="desk" class="form-label">Deskripsi</label>
                                        <textarea id="desk" type="text" class="form-control" placeholder="Deskripsi template" style="max-height: 30vh; min-height: 15vh;" wire:model.defer="desc"></textarea>
                                    </div>
                                    @error('desc')
                                    <div class="text-theme-21 mt-2">{{ $message }}</div>
                                    @enderror
                                    

                                </div>
                            </div>

                            
                            <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5 mt-5">

                                <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down w-4 h-4 mr-2">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg> Template Files </div>
                                <div class="mt-5">
                                    <div class="mt-4 bx-form-file">
                                        <label class="form-label">File Konfigurasi</label>
                                        <div class="bx-field">
                                            <input type="text" class="col-7 form-control placeholder disabled" disabled placeholder="File name">
                                            <button type="button" class="btn btn-primary btn-sm" onclick="bxupload(this)">
                                                <span wire:target="config_file" wire:loading.remove>Pilih File</span>
                                                <span wire:target="config_file" wire:loading.class.remove="d-none" class="d-none">Loading...</span>
                                            </button>
                                        </div>
                                        <input type="file" wire:model="config_file" class="inp-file" hidden onchange="bxfilechange(this, event)">
                                    </div>
                                    @error('config_file')
                                        <div class="text-theme-21 mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mt-5">
                                    <div class="mt-4 bx-form-file">
                                        <label class="form-label">Template File</label>
                                        <div class="bx-field">
                                            <input type="text" class="col-7 form-control placeholder disabled" disabled placeholder="File name" value={{ $template_file?->getPath() }}>
                                            <button type="button" class="btn btn-primary btn-sm" onclick="bxupload(this)">
                                                <span wire:target="template_file" wire:loading.remove>Pilih File</span>
                                                <span wire:target="template_file" wire:loading.class.remove="d-none" class="d-none">Loading...</span>
                                            </button>
                                        </div>
                                        <input type="file" wire:model="template_file" class="inp-file" hidden onchange="bxfilechange(this, event)">
                                    </div>
                                    @error('template_file')
                                    <div class="text-theme-21 mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            
                            <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5 mt-5">
                                <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5"> <i data-feather="chevron-down" class="w-4 h-4 mr-2"></i> Konfigurasi Template </div>
                                <div class="mt-5">

                                    <div>
                                        <label for="v" class="form-label">Versi Template</label>
                                        <input id="v" disabled type="text" class="form-control disabled" value="{{ $version }}">
                                    </div>
                                    @error('version')
                                    <div class="text-theme-21 mt-2">{{ $message }}</div>
                                    @enderror

                                    @if (empty($variables) === false)
                                        <div class="mt-3">
                                            <label for="v" class="form-label">Template Variables</label>
                                        </div>
                                    @endif

                                    @php
                                        echo iterateData($variables)
                                    @endphp

                                </div>
                            </div>

                            @php
                                function iterateData(array $array) {
                                    $elements = "";
                                    foreach ($array as $key => $value) {

                                        if($value['data_type'] === "array") {

                                            $br_name = ucwords($value['name']);
                                            
                                            $elements .= "<div class=\"mt-4\">
                                                                <h4 class=\"form-label\">Array {$br_name}</h4>
                                                            </div>";

                                            foreach ($value['value'] as $key => $array) {

                                                if(is_array($array)) {
                                                    $array = array_values($array);

                                                    foreach ($array as $v) {
                                                        $elements .= "<input disabled type='text' class='form-control disabled mt-2' value='{$v} '>";
                                                    }
                                                }
                                                
                                            }

                                            continue;
                                        }

                                        $name = _rename($value['name']);

                                        $elements .= "<input disabled type='text' class='form-control disabled mt-2' value='{$name} : {$value['value']}'>";
                                    }

                                    return $elements;
                                }

                                function _rename($str) {
                                    try {
                                        
                                        $arr_name = explode("_", $str);
                                        
                                        $name = join(" ", $arr_name);

                                        return ucwords($name);
                                    } catch (\Throwable $th) {
                                        return ucwords($str);
                                    }
                                }

                            @endphp


                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Post Content -->
            <!-- BEGIN: Post Info -->
            <div class="col-span-12 lg:col-span-4">

                
            <div class="intro-y box p-5">
                    <div class="border-2 border-dashed shadow-sm border-gray-200 dark:border-dark-5 rounded-md p-5">
                        <div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                            @if($cover === null) 
                                <img class="rounded-md" alt="Tinker Tailwind HTML Admin Template" src="{{ $_cover ?? "http://via.placeholder.com/640x360" }}">
                            @else
                                <img class="rounded-md" alt="Tinker Tailwind HTML Admin Template" src="{{ $cover->temporaryUrl() }}">
                            @endif
                            <div class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-theme-21 right-0 top-0 -mr-2 -mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x w-4 h-4">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg> 
                            </div>
                        </div>
                        <div class="mx-auto cursor-pointer relative mt-5">
                            <button type="button" class="btn btn-primary w-full" wire:loading.attr="disabled">
    
                                <span wire:target="cover" wire:loading.remove>Ubah Foto</span>
                                    
                                <div wire:target="cover" wire:loading.flex style="justify-content: center; align-items: center; margin: 0px; padding: 5px 0px">
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
                            
                            <input type="file" wire:model="cover" class="w-full h-full top-0 left-0 absolute opacity-0">
                        </div>
                    </div>
                    @error('cover')
                        <div class="text-theme-21 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="intro-y box p-5 mt-3">
                    <div class="mt-3">
                        <label for="price-field" class="form-label">Harga</label>
                        <input id="price-field" type="text" wire:model.defer="price" oninput="formatNumber(this)" class="form-control" placeholder="Harga Template">
                        @error('price')
                        <div class="text-theme-21 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Kategori</label>
                        <div class="slx-field" data-item='@json($_categories)' data-selected='@json($categories ?? [])' data-comp="@this" data-model="categories">
                            <input type="hidden">
                            <input type="text" class="slx-input" placeholder="Pilih item">
                            <div class="selectable-box">
                            </div>
                        </div>
                        @error('categories')
                        <div class="text-theme-21 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mt-3" >
                        <label for="regular-form-3" class="form-label">Tags</label> 
                        <div style="display: flex; flex-direction: row">
                            <input id="tags-field" type="text" class="form-control" placeholder="Tags" onkeypress="if(event.key === 'Enter') addTag()">
                            <button class="btn btn-success-soft btn-sm ml-2" onclick="addTag()"> <i data-feather="plus" style="height: 17px; width: 17px"></i> </button>
                        </div>
                        <div class="mt-3 w-100" style="display: inline-block">
                            @forelse ($tags ?? [] as $tag)
                                <div class="badge">
                                    <span class="text">{{ $tag }}</span>
                                    <button class="close-btn" onclick="removeTag('{{ $loop->index }}')">&times;</button>
                                </div>
                                  
                            @empty
                                
                            @endforelse
                        </div>
                        @error('tags')
                        <div class="text-theme-21 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                

                <div class="intro-y box p-5 mt-4">
                    <div class="form-check flex-col items-start mt-3">
                        <label for="post-form-5" class="form-check-label ml-0 mb-2">Publis</label>
                        <input id="post-form-5" class="form-check-switch" type="checkbox" wire:model="publicity">
                    </div>
                    <div class="form-check flex-col items-start mt-3">
                        <label for="post-form-6" class="form-check-label ml-0 mb-2">komentar</label>
                        <input id="post-form-6" class="form-check-switch" type="checkbox" wire:model="commentable">
                    </div>
                    <div class="form-check flex-col items-start mt-3">
                        <label for="post-form-7" class="form-check-label ml-0 mb-2">Feedback</label>
                        <input id="post-form-7" class="form-check-switch" type="checkbox" wire:model="feedbackable">
                    </div>
                </div>

            </div>

            <script>
            
                document.addEventListener('livewire:load', function () {

                    formatNumber(document.getElementById('price-field'));

                    window.addTag = () => {
                        let tagEl = document.getElementById('tags-field');
                        let val = tagEl.value;

                        if(val.length <= 3) return;

                        @this.addTag(val)
                        tagEl.value = "";
                    }

                    window.removeTag = (index) => {
                        @this.removeTag(index);
                    };
                    
                })
            
            </script>

            
            <!-- END: Post Info -->
        </div>
</div>
