<?php

namespace App\Http\Livewire\Dashboard\ProfilePage\AccountPage\Components;

use App\Http\Livewire\Dashboard\_Dashboard;
use Livewire\WithPagination;

class EventsTable extends _Dashboard
{
    
    public $username;

    public $page_title = "Daftar Event Peternakan";

    public $queryString = ['search_field', 'search_operator', 'search_value', 'key'];

    public $searchable_fields = [
        ['name', 'Nama'], ['note', 'Catatan'], ['date', 'Tanggal Event'], ['type', 'Tipe'],
    ];

    public function mount(string $username)
    {
        $this->pushBread(3, $this->page_title);
        $this->defaultSearchAttr("name", "like");

        $this->username = $username;
    }

    public function render()
    {
        try {
            $user = get_user($this->username);

            $page_size = $this->page_size;

            if($page_size >= 40) {
                $page_size = 40;
            }

            if($this->search_value != null) {

                $opr = $this->searchOperator();

                $xev = $user->events()->where($this->search_field, $opr, $opr == 'like' ? "%{$this->search_value}%" : $this->search_value)
                    ->orderBy('created_at', 'DESC')->paginate($page_size);

            } else {
                $xev = $user->events()->orderBy('created_at', 'DESC')->paginate($page_size);
            }

            $data['events'] = $xev;

            return view('livewire.dashboard.profile-page.account-page.components.eventss-table', $data);

        } catch (\Throwable $th) {

            $this->onRenderError($th);
        }
    }
}
