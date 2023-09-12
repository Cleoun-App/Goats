<div>
    <div class="flex items-center mt-8">
        <h2 class="intro-y text-lg font-medium mr-auto">
            {{ $pageTitle }}
        </h2>
    </div>
    <!-- BEGIN: Wizard Layout -->
    <div class="intro-y box py-10 sm:pt-20 mt-5">
        <div class="flex justify-center">
            @foreach ($section as $sect)
                @if ($section_active == $loop->index)
                    <button class="intro-y w-10 h-10 rounded-full btn btn-primary mx-2">{{ $loop->index + 1 }}</button>
                @else
                    <button wire:key="xla{{ $loop->index }}" class="intro-y w-10 h-10 rounded-full btn bg-gray-200 dark:bg-dark-1 text-gray-600 mx-2" wire:click="goto({{ $loop->index}})">{{ $loop->index + 1 }}</button>
                @endif
            @endforeach
        </div>
        <div class="px-5 mt-10">
            <div class="font-medium text-center text-lg">{{ $sect_title }}</div>
            <div class="text-gray-600 text-center mt-2">{{ $sect_subtitle }}</div>
        </div>
        <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200 dark:border-dark-5">
            <div class="font-medium text-base">{{ $form_title }}</div>
            <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                @if ($section_active == 0)
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-1" class="form-label">Alamat Email</label>
                        <input id="input-wizard-1" type="text" class="form-control" wire:model="email" wire:key="xemail" placeholder="...">
                        @error('email')
                        <div class="text-theme-21 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-2" class="form-label">Nama</label>
                        <input id="input-wizard-2" type="text" class="form-control" wire:model="name" wire:key="xname" placeholder="...">
                        @error('name')
                        <div class="text-theme-21 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-3" class="form-label">Username</label>
                        <input id="input-wizard-3" type="text" class="form-control" wire:model="username" wire:key="xusername" placeholder="...">
                        @error('username')
                        <div class="text-theme-21 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-4" class="form-label">Nomor Telpon</label>
                        <input id="input-wizard-4" type="text" class="form-control" wire:model="nomor_telp" wire:key="xnomor_telp" placeholder="...">
                        @error('nomor_telp')
                        <div class="text-theme-21 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-5" class="form-label">Alamat</label>
                        <input id="input-wizard-5" type="text" class="form-control" wire:model="address" wire:key="xaddress" placeholder="...">
                        @error('address')
                        <div class="text-theme-21 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-5" class="form-label">Role Pengguna</label>
                        <input id="input-wizard-5" type="text" class="form-control" disabled value="{{ $role }}">
                    </div>
                @endif

                
                @if ($section_active == 1)
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <div>
                            <label for="f-password" class="form-label">Password</label>
                            <input id="f-password" wire:key="f-password" type="password" placeholder="Masukan password" class="form-control @error('password') border-theme-21 @enderror" placeholder="Input text" wire:model.defer="password">
                            @error('password')
                            <div class="text-theme-21 mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6 ">
                        <div>
                            <label for="fc-password" class="form-label">Konfirmasi Password</label>
                            <input id="fc-password" wire:key="fc-password" type="password" placeholder="Masukan password baru" class="form-control @error('password') border-theme-21 @enderror" placeholder="Input text" wire:model.defer="c_password">
                            @error('c_password')
                            <div class="text-theme-21 mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endif

                <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                    @if ($section_active == count($section) - 1)
                        <button wire:key="x122" class="btn btn-primary w-24" wire:click="goto({{ $section_active - 1 }})">Previous</button>
                        <button wire:key="t176" class="btn btn-success w-24 ml-2" wire:click="addUser">
                            <span wire:target="addUser" wire:loading.remove>Simpan</span>
                                
                            <div wire:target="addUser" wire:loading.flex style="justify-content: center; align-items: center; margin: 0px; padding: 5px 0px">
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
                    @else
                        <button wire:key="y100" class="btn btn-secondary w-24" wire:click="goto({{ $section_active - 1 }})">Previous</button>
                        <button wire:key="y122" class="btn btn-primary w-24 ml-2" wire:click="goto({{ $section_active + 1 }})">Next</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- END: Wizard Layout -->
</div>
