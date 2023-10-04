<?php

namespace App\Http\Livewire\Dashboard\UserPages\UserManagementPages\UserRolePage;

use App\Http\Livewire\Dashboard\_Dashboard;
use App\Http\Livewire\Dashboard\DispatchType;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UserRolePage extends _Dashboard
{
    use WithPagination;

    public $page_title = "Manajemen Role Pengguna";

    public $listeners = [
        'refresh-page' => '$refresh',
    ];

    public $queryString = ['search_field', 'search_operator', 'search_value', 'page_size'];

    public $searchable_fields = [
        ['name', 'Nama'], ['created_at', 'Tgl Dibuat'], ['guard_name', 'Nama Guard']
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

            $roles = Role::where($this->search_field, $opr, $opr == 'like' ? "%{$this->search_value}%" : $this->search_value)
                ->orderBy('created_at', 'DESC')->paginate($this->page_size);

        } else {
            $roles = Role::orderBy('created_at', 'DESC')->paginate($this->page_size);
        }

        $data['roles'] = $roles;
        $data['pageTitle'] = "Tabel Role";
        $data['user'] = auth_user();

        return view('livewire.dashboard.user-pages.user-management-pages.user-role-page.user-role-page', $data)
            ->layout('layouts.app', $data);
    }

    public function deleteRole($id)
    {
        try {

            $role = Role::findOrFail($id);

            $isFind = array_search($role->name, $this->main_roles);

            if($isFind === false) {
                $role->delete();

               return $this->dispatch(DispatchType::Success, [
                    'title' => 'Berhasil',
                    'message' => 'Role berhasil di hapus'
                ]);
            }

            throw new \Exception("Role utama tidak bisa di-hapus!!");


        } catch (\Throwable $th) {
            $this->dispatch(DispatchType::Error, [
                'title' => 'Gagal',
                'message' => $th->getMessage(),
            ]);
        }
    }
}
