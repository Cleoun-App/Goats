<?php

namespace App\Http\Livewire\Dashboard\ProfilePage\AccountPage\Components;

use App\Http\Livewire\Dashboard\_Dashboard;

class EventsTable extends _Dashboard
{
    
    public $username;

    public $page_title = "Daftar Event Peternakan";

    public $queryString = ['search_field', 'search_operator', 'search_value', 'key'];

    public $searchable_fields = [
        ['name', 'Nama'], ['note', 'Catatan'], ['date', 'Tanggal Event'],
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

            $page_size = 5;

            if($this->search_value != null) {

                $opr = $this->searchOperator();

                $events = $user->events()->where($this->search_field, $opr, $opr == 'like' ? "%{$this->search_value}%" : $this->search_value)
                    ->orderBy('created_at', 'DESC')->paginate($page_size);

            } else {
                $events = $user->events()->orderBy('created_at', 'DESC')->paginate($page_size);
            }

            $data['events'] = $events;

            $data['user'] = $user;

            return view('livewire.dashboard.profile-page.account-page.components.events-table', $data);

        } catch (\Throwable $th) {

            $this->onRenderError($th);
        }
    }
}
