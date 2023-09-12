<?php

namespace App\Http\Livewire\Dashboard\UserPages\UserManagementPages\UserPermissionPage;

use App\Http\Livewire\Dashboard\_Dashboard;
use App\Http\Livewire\Dashboard\DispatchType;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class UserPermissionPage extends _Dashboard
{
    use WithPagination;

    public $page_title = "Manajemen Perizinan Pengguna";

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

            $permissions = Permission::where($this->search_field, $opr, $opr == 'like' ? "%{$this->search_value}%" : $this->search_value)
                ->orderBy('created_at', 'DESC')->paginate($this->page_size);

        } else {
            $permissions = Permission::orderBy('created_at', 'DESC')->paginate($this->page_size);
        }

        $data['roles'] = $permissions;
        $data['pageTitle'] = $this->page_title;
        $data['user'] = auth_user();

        return view('livewire.dashboard.user-pages.user-management-pages.user-permission-page.user-permission-page', $data)
            ->layout('layouts.app', $data);
    }

    public function deletePermission($id)
    {
        try {

            $permission = Permission::findOrFail($id);

            $isFind = array_search($permission->name, $this->main_permissions);

            if($isFind == false) {
                $permission->delete();

               return $this->dispatch(DispatchType::Success, [
                    'title' => 'Berhasil',
                    'message' => 'Role berhasil di hapus'
                ]);
            }

            throw new \Exception("Perizinan utama tidak bisa di-hapus!!");


        } catch (\Throwable $th) {
            $this->dispatch(DispatchType::Error, [
                'title' => 'Gagal',
                'message' => $th->getMessage(),
            ]);
        }
    }

}
