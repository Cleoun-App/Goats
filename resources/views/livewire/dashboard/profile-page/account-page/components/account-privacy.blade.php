<div class="intro-y box lg:mt-5">
    <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
        <h2 class="font-medium text-base mr-auto">
            Ubah Password
        </h2>
    </div>
    <div class="p-5">
        <div class="flex flex-col-reverse xl:flex-row flex-col">
            <div class="flex-1 mt-6 xl:mt-0">
                <div class="grid grid-cols-12 gap-x-5">
                    <div class="col-span-12 xxl:col-span-6">
                        <div>
                            <label for="f-password" class="form-label">Password</label>
                            <input id="f-password" type="password" placeholder="Masukan password" class="form-control @error('password') border-theme-21 @enderror" placeholder="Input text" wire:model.defer="password">
                            @error('password')
                            <div class="text-theme-21 mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-12 xxl:col-span-6 mt-2">
                        <div>
                            <label for="f-password-new" class="form-label">Password Baru</label>
                            <input id="f-password-new" type="password" placeholder="Masukan password baru" class="form-control @error('password') border-theme-21 @enderror" placeholder="Input text" wire:model.defer="password_new">
                            @error('password_new')
                            <div class="text-theme-21 mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-12 xxl:col-span-6 mt-2">
                        <div>
                            <label for="f-password-new-confirm" class="form-label">Konfirmasi Password</label>
                            <input id="f-password-new-confirm" type="password" placeholder="Konfirmasi password baru" class="form-control @error('password') border-theme-21 @enderror" placeholder="Input text" wire:model.defer="password_confirm">
                            @error('password_confirm')
                            <div class="text-theme-21 mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button id="tgl-notif" type="button" wire:click="updatePassword" class="btn btn-primary w-40 mt-4" wire:loading.attr="disabled" wire:loading.class="btn-secondary" wire:loading.class.remove="bg-blue">
        
                    <span wire:loading.remove wire:target="updatePassword">Simpan Perubahan</span>
                        
                    <div wire:loading.flex wire:target="updatePassword" style="justify-content: center; align-items: center; margin: 0px; padding: 5px 0px">
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
    </div>
</div>