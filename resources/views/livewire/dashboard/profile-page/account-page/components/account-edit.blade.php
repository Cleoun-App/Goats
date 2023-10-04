<div>

    <div class="intro-y box lg:mt-5">
        <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">
                Update Data Pengguna
            </h2>
        </div>
        <div class="p-5">
            <div class="flex flex-col-reverse xl:flex-row flex-col">
                <div class="flex-1 mt-6 xl:mt-0">
                    <div class="grid grid-cols-12 gap-x-5">
                        <div class="col-span-12 xxl:col-span-6">
                            <div>
                                <label for="update-profile-form-1" class="form-label">Nama</label>
                                <input id="update-profile-form-1" type="text" class="form-control @error('name') border-theme-21 @enderror" placeholder="Input text" wire:model.defer="name">
                                @error('name')
                                <div class="text-theme-21 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-span-12 xxl:col-span-6">
                            <div class="mt-2">
                                <label for="update-profile-form-1" class="form-label">Nama Pengguna</label>
                                <input id="update-profile-form-1" type="text" class="form-control @error('username') border-theme-21 @enderror" placeholder="Masukan nama pengguna" wire:model.defer="username">
                                @error('username')
                                <div class="text-theme-21 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-span-12 xxl:col-span-6">
                            <div class="mt-2">
                                <label for="update-profile-form-1" class="form-label">Alamat</label>
                                <input id="update-profile-form-1" type="text" class="form-control @error('address') border-theme-21 @enderror" placeholder="Masukan Alamat Pengguna" wire:model.defer="address">
                                @error('address')
                                <div class="text-theme-21 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-span-12 xxl:col-span-6">
                            <div class="mt-3">
                                <label for="update-profile-form-1" class="form-label">Email</label>
                                <input id="update-profile-form-1" disabled type="email" class="form-control disabled @error('email') border-theme-21 @enderror" placeholder="Masukan Email" value="{{ $email }}" style="color: grey">
                                @error('email')
                                <div class="text-theme-21 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-span-12 xxl:col-span-6">
                            <div class="mt-2">
                                <label for="update-profile-form-1" class="form-label">Gender</label>
                                <select class="form-select sm:mt-2 sm:mr-2 @error('gender') border-theme-21 @enderror" aria-label=".form-select-lg example" wire:model.defer="gender">
                                    <option>Pilih Gender</option>
                                    @foreach (['male', 'female'] as $g)
                                        <option value="{{ $g }}" @if($g === $gender) selected @endif style="text-transform: capitalize">{{ $g }}</option>
                                    @endforeach
                                </select>
                                @error('gender')
                                <div class="text-theme-21 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
    
                    <!-- BEGIN: Notification Content -->
                    <div id="tgl-notif" class="toastify-content hidden flex">
                        <div class="font-medium">Yay! Updates Published!</div> <a class="font-medium text-theme-25 dark:text-gray-500 mt-1 sm:mt-0 sm:ml-40" href="">Review Changes</a>
                    </div> 
                    <!-- END: Notification Content -->
                    <!-- BEGIN: Notification Toggle -->
                    <button id="tgl-notif" type="button" wire:click="perbahrui" class="btn btn-primary w-40 mt-4" wire:loading.attr="disabled" wire:loading.class="btn-secondary" wire:loading.class.remove="bg-blue">
    
                        <span wire:loading.remove wire:target="perbahrui">Simpan Perubahan</span>
                            
                        <div wire:loading.flex wire:target="perbahrui" style="justify-content: center; align-items: center; margin: 0px; padding: 5px 0px">
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
                <div class="w-52 mx-auto xl:mr-0 xl:ml-6">
                    <div class="border-2 border-dashed shadow-sm border-gray-200 dark:border-dark-5 rounded-md p-5">
                        <div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                            @if($photo === null) 
                                <img class="rounded-md" alt="Tinker Tailwind HTML Admin Template" src="{{ $pp }}">
                            @else
                                <img class="rounded-md" alt="Tinker Tailwind HTML Admin Template" src="{{ $photo->temporaryUrl(); }}">
                            @endif
                            <div class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-theme-21 right-0 top-0 -mr-2 -mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x w-4 h-4">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg> 
                            </div>
                        </div>
                        <div class="mx-auto cursor-pointer relative mt-5">
                            <button type="button" class="btn btn-primary w-full" wire:loading.attr="disabled" wire:loading.class="btn-secondary" wire:loading.class.remove="bg-blue">
    
                                <span wire:loading.remove>Ubah Foto</span>
                                    
                                <div wire:loading.flex style="justify-content: center; align-items: center; margin: 0px; padding: 5px 0px">
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
                            
                            <input type="file" wire:model="photo" class="w-full h-full top-0 left-0 absolute opacity-0">
                        </div>
                    </div>
                    @error('photo')
                        <div class="text-theme-21 mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    
    @component('components.modal-loading-indicator')
    @endcomponent

</div>