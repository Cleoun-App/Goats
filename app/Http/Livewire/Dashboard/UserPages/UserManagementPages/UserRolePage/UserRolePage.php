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

    public $search_field = 'name';
    public $search_operator = 'like';
    public $search_value;

    public $listeners = [
        'refresh-page' => '$refresh',
    ];

    public $queryString = ['search_field', 'search_operator', 'search_value', 'page_size'];

    public $page_size = 10;

    public $searchable_fields = [
        ['name', 'Nama'], ['created_at', 'Tgl Dibuat'], ['guard_name', 'Nama Guard']
    ];

    public $search_operators = [
        ['like', 'Sama Dengan'],  ['dx10', 'Kurang Dari'], ['kl72', 'Lebih Dari'],
        ['nb19', 'Lebih Kecil Sama Dengan'], ['vr05', 'Lebih Besar Sama Dengan'], ['nx00', 'Tidak Sama Dengan']
    ];


    public function mount()
    {
        $this->search_field = request()->get('search_field', 'name');
        $this->search_operator = request()->get('search_operator', 'like');

        $this->pushBread(1, $this->page_title);
    }

    public function render()
    {
        $page_size = $this->page_size;

        if($page_size >= 40) {
            $page_size = 40;
            $this->page_size = $page_size;
        }

        if($this->search_value != null) {

            $opr = null;

            switch($this->search_operator) {
                case "dx10":
                    $opr = "<";
                    break;
                case "kl72":
                    $opr = ">";
                    break;
                case "nb19":
                    $opr = "<=";
                    break;
                case "vr05":
                    $opr = ">=";
                    break;
                case "nx00":
                    $opr = "!=";
                    break;
                default:
                    $opr = 'like';
            }

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
