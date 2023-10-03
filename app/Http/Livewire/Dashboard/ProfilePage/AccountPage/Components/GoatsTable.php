<?php

namespace App\Http\Livewire\Dashboard\ProfilePage\AccountPage\Components;

use App\Http\Livewire\Dashboard\_Dashboard;
use Livewire\WithPagination;

class GoatsTable extends _Dashboard
{
    use WithPagination;

    public $username;

    public $page_title = "Daftar Kambing Pengguna";

    public $queryString = ['search_field', 'search_operator', 'search_value', 'key'];

    public $searchable_fields = [
        ['name', 'Nama'], ['group', 'Group'], ['status', 'Status'],
        ['breed', 'Breed'], ['gender', 'Kelamin'], ['tag', 'Tag']
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

                $goats = $user->goats()->where($this->search_field, $opr, $opr == 'like' ? "%{$this->search_value}%" : $this->search_value)
                    ->orderBy('created_at', 'DESC')->paginate($page_size);

            } else {
                $goats = $user->goats()->orderBy('created_at', 'DESC')->paginate($page_size);
            }

            $data['goats'] = $goats;

            $data['user'] = $user;

            return view('livewire.dashboard.profile-page.account-page.components.goats-table', $data);

        } catch (\Throwable $th) {

            $this->onRenderError($th);
        }
    }
}
