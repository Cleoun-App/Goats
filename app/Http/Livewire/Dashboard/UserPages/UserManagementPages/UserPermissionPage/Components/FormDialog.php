<?php

namespace App\Http\Livewire\Dashboard\UserPages\UserManagementPages\UserPermissionPage\Components;

use App\Http\Livewire\Dashboard\_Dashboard;
use App\Http\Livewire\Dashboard\DispatchType;
use Spatie\Permission\Models\Permission;

class FormDialog extends _Dashboard
{
    public $id_modal;
    public $title;

    public $prm_id;
    public $permission;
    public $guard_name = 'web';

    public function mount($id_modal, $title, $prm_id = null)
    {
        $this->id_modal = $id_modal;
        $this->title = $title;

        $prm = Permission::find($prm_id);

        if($prm instanceof Permission) {
            $this->prm_id = $prm->id;
            $this->permission = $prm->name;
            $this->guard_name = $prm->guard_name;
        }
    }

    public function render()
    {
        return view('livewire.dashboard.user-pages.user-management-pages.user-permission-page.components.form-dialog');
    }

    public function save()
    {
        try {

            $this->validate([
                'permission' => ['required','unique:permissions,name,' . $this->prm_id . ",id", 'min:3', 'max:45'],
                'guard_name' => ['required', 'min:3', 'max:9']
            ]);

        } catch (\Throwable $th) {
            return $this->dispatch(DispatchType::Error, [
                 'title' => 'ValidasiError',
                 'message' => $th->getMessage(),
             ]);
        }

        $role = Permission::find($this->prm_id ?? 0);

        if($role instanceof Permission) {

            $isFind = array_search($role->name, $this->main_permissions);

            if($isFind !== false) {
                return $this->dispatch(DispatchType::Error, [
                    'title' => 'Error',
                    'message' => 'Permission utama tidak bisa di-ubah!!',
                ]);
            }

            $role->update([
                'name' => strtolower($this->permission),
                'guard_name' => strtolower($this->guard_name),
            ]);

            $this->dispatch(DispatchType::Success, [
                'title' => 'Berhasil',
                'message' => 'Permission berhasil di-update',
            ]);

        } else {

            Permission::create([
                'name' => strtolower($this->permission),
                'guard_name' => strtolower($this->guard_name),
            ]);

            $this->dispatch(DispatchType::Success, [
                'title' => 'Berhasil',
                'message' => 'Permission berhasil di-tambahkan',
            ]);

            $this->permission = "";
        }

        $this->emit('refresh-page');
    }
}
