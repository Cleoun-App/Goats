<div>

    <div class="intro-y box lg:mt-5">
        <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">
                Pengaturan Umum
            </h2>
        </div>
        <div class="p-5">
            <div class="flex flex-col-reverse xl:flex-row flex-col">
                <div class="flex-1 mt-6 xl:mt-0">
                    <div class="grid grid-cols-12 gap-x-5">
                        <div class="col-span-12">
                            <label>Mode Tampilan</label>
                            <div class="mt-2">
                                <div class="form-check" onclick="switchVsmode()"> 
                                    <input id="checkbox-switch-7"  class="form-check-switch" type="checkbox" wire:model="vs_mode" value="{{ $vs_mode }}"> 
                                    <label class="form-check-label" for="checkbox-switch-7">@if ($vs_mode == false) Light @else Dark @endif Mode</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary w-35 mt-4" wire:click="updateConfig">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    
    </div>
    
    @component('components.modal-loading-indicator')
    @endcomponent

</div>