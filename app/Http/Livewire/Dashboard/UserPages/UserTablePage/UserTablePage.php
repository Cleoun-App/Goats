<?php

namespace App\Http\Livewire\Dashboard\UserPages\UserTablePage;

use App\Http\Livewire\Dashboard\_Dashboard;
use App\Http\Livewire\Dashboard\DispatchType;
use App\Models\User;
use Livewire\WithPagination;

class UserTablePage extends _Dashboard
{
    use WithPagination;

    public $page_title = "Tabel Pengguna";

    public $queryString = ['search_field', 'search_operator', 'search_value', 'page_size'];

    public $searchable_fields = [
        ['name', 'Nama'], ['status', 'Status'],
        ['username', 'Username'], ['email', 'Email']
    ];

    public function mount()
    {
        $this->pushBread(1, $this->page_title);
        $this->defaultSearchAttr("name", "like");
    }

    public function render()
    {
        $page_size = $this->page_size;

        if($page_size >= 40) {
            $page_size = 40;
            $this->page_size = $page_size;
        }

        if($this->search_value != null) {

            $opr = $this->searchOperator();

            $users = User::where($this->search_field, $opr, $opr == 'like' ? "%{$this->search_value}%" : $this->search_value)
                ->orderBy('created_at', 'DESC')->paginate($this->page_size);

        } else {
            $users = User::orderBy('created_at', 'DESC')->paginate($this->page_size);
        }

        $data['users'] = $users;
        $data['pageTitle'] = "Tabel Pengguna";
        $data['user'] = auth_user();

        return view('livewire.dashboard.user-pages.user-table-page.user-table-page', $data)
            ->layout('layouts.app', $data);
    }

    public function deleteUser($id)
    {
        try {

            $user = User::findOrFail($id);

            $user->goats()->delete();
            
            $user->group()->delete();
            
            $user->events()->delete();

            $user->milknote()->delete();

            $user->delete();

            return $this->dispatch(DispatchType::Success, [
                 'title' => 'Berhasil',
                 'message' => 'User berhasil di hapus'
             ]);

        } catch (\Throwable $th) {
            $this->dispatch(DispatchType::Error, [
                'title' => 'Gagal',
                'message' => $th->getMessage(),
            ]);
        }
    }
}
