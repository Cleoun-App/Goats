<?php

namespace App\Http\Livewire\Dashboard\EventPages\EventTypesTablePage;

use App\Http\Livewire\Dashboard\_Dashboard;
use App\Http\Livewire\Dashboard\DispatchType;
use App\Models\EventType;
use Livewire\WithPagination;

class EventTypesTablePage extends _Dashboard
{
    use WithPagination;

    public $page_title = "Tabel Jenis Event";

    public $queryString = ['search_field', 'search_operator', 'search_value', 'page_size'];

    public $listeners = [
        'refresh-page' => '$refresh',
    ];

    public $searchable_fields = [
        ['name', 'Nama']
    ];

    public function mount()
    {
        $this->pushBread(1, $this->page_title);
        $this->defaultSearchAttr("name", "like");
    }

    public function render()
    {
        try {

            $page_size = 5;

            if($this->search_value != null) {

                $opr = $this->searchOperator();

                $events = EventType::where($this->search_field, $opr, $opr == 'like' ? "%{$this->search_value}%" : $this->search_value)
                    ->orderBy('created_at', 'DESC')->paginate($page_size);

            } else {
                $events = EventType::orderBy('created_at', 'DESC')->paginate($page_size);
            }

            $data['events'] = $events;
            $data['pageTitle'] = $this->page_title;

            return view('livewire.dashboard.event-pages.event-types-table-page.event-types-table-page', $data)
                ->layout('layouts.app', $data);

        } catch (\Throwable $th) {

            $this->onRenderError($th);
        }
    }


    public function deleteRole($id)
    {
        try {

            $role = EventType::findOrFail($id);

            $role->delete();

            return $this->dispatch(DispatchType::Success, [
                 'title' => 'Berhasil',
                 'message' => 'Role berhasil di hapus'
             ]);

        } catch (\Throwable $th) {
            $this->dispatch(DispatchType::Error, [
                'title' => 'Gagal',
                'message' => $th->getMessage(),
            ]);
        }
    }
}
