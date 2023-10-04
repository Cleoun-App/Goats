<?php

namespace App\Http\Livewire\Dashboard\EventPages\Event\Components;

use App\Http\Livewire\Dashboard\_Dashboard;
use App\Http\Livewire\Dashboard\DispatchType;
use Illuminate\Support\Str;
use App\Models\EventType;

class EventFormDialog extends _Dashboard
{
    
    public $id_modal;
    public $title;

    public $event_id;
    public $event_name;

    public function mount($id_modal, $title, $event_id = null)
    {
        $this->id_modal = $id_modal;
        $this->title = $title;

        $event = EventType::find($event_id);

        if($event instanceof EventType) {
            $this->event_id = $event->id;
            $this->event_name = $event->name;
        }
    }

    public function render()
    {
        return view('livewire.dashboard.event-pages.event.components.event-form-dialog');
    }

    public function save() {
        
        try {

            $this->validate([
                'event_name' => ['required','unique:event_types,name,' . $this->event_id . ",id", 'min:3', 'max:30'],
            ]);

        } catch (\Throwable $th) {
            return $this->dispatch(DispatchType::Error, [
                 'title' => 'ValidasiError',
                 'message' => $th->getMessage(),
             ]);
        }
        

        $event = EventType::find($this->event_id ?? 0);

        if($event instanceof EventType) {

            $event->update([
                'name' => strtolower($this->event_name),
                'slug' => Str::slug($this->event_name),
            ]);

            $this->dispatch(DispatchType::Success, [
                'title' => 'Berhasil',
                'message' => 'Event berhasil di-update',
            ]);

        } else {

            EventType::create([
                'name' => strtolower($this->event_name),
                'slug' => Str::slug($this->event_name),
            ]);

            $this->dispatch(DispatchType::Success, [
                'title' => 'Berhasil',
                'message' => 'Event berhasil di-tambahkan',
            ]);

            $this->event_name = "";
        }

        $this->emit('refresh-page');
    }
}
