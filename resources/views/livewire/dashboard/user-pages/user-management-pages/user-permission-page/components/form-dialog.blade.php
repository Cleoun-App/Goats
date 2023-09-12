<div>
    <div id="{{ $id_modal }}" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">{{ $title }}</h2>
                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12"> 
                        <label for="prm-name" class="form-label">Nama Permission</label> 
                        <input id="prm-name" type="text" class="form-control" placeholder="..." wire:model.defer="permission">
                        @error('prm_name')
                            <div class="text-theme-21 mt-2">{{ $message }}</div>
                        @enderror
                     </div>
                    <div class="col-span-12"> 
                        <label for="guard_name" class="form-label">Guard Name</label> 
                        <input id="guard_name" type="text" class="form-control" placeholder="..." wire:model.defer="guard_name"> 
                        @error('guard_name')
                            <div class="text-theme-21 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div> <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer text-right"> 
                    <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Batal</button> 
                    <button type="button" data-dismiss="modal" class="btn btn-primary w-25" wire:click="save">Simpan</button> 
                </div> <!-- END: Modal Footer -->
            </div>
        </div>
    </div> 
    
</div>