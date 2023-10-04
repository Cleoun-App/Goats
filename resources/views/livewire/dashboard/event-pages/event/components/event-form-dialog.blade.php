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
                        <label for="event-name" class="form-label">Nama event</label> 
                        <input id="event-name" type="text" class="form-control" placeholder="..." wire:model.defer="event_name">
                        @error('event_name')
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