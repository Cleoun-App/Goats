<?php

namespace App\Http\Livewire\Dashboard\UserPages\UserManagementPages\UserRolePage\Components;

use App\Http\Livewire\Dashboard\_Dashboard;
use App\Http\Livewire\Dashboard\DispatchType;
use Spatie\Permission\Models\Role;

class FormDialog extends _Dashboard
{
    public $id_modal;
    public $title;

    public $role_id;
    public $role_name;
    public $guard_name = 'web';

    public function mount($id_modal, $title, $role_id = null)
    {
        $this->id_modal = $id_modal;
        $this->title = $title;

        $role = Role::find($role_id);

        if($role instanceof Role) {
            $this->role_id = $role->id;
            $this->role_name = $role->name;
            $this->guard_name = $role->guard_name;
        }
    }

    public function render()
    {
        return view('livewire.dashboard.user-pages.user-management-pages.user-role-page.components.form-dialog');
    }

    public function save()
    {
        try {

            $this->validate([
                'role_name' => ['required','unique:roles,name,' . $this->role_id . ",id", 'min:3', 'max:9'],
                'guard_name' => ['required', 'min:3', 'max:9']
            ]);

        } catch (\Throwable $th) {
            return $this->dispatch(DispatchType::Error, [
                 'title' => 'ValidasiError',
                 'message' => $th->getMessage(),
             ]);
        }

        $role = Role::find($this->role_id ?? 0);

        if($role instanceof Role) {

            $isFind = array_search($role->name, $this->main_roles);

            if($isFind !== false) {
                return $this->dispatch(DispatchType::Error, [
                    'title' => 'Error',
                    'message' => 'Role utama tidak bisa di-ubah!!',
                ]);
            }

            $role->update([
                'name' => strtolower($this->role_name),
                'guard_name' => strtolower($this->guard_name),
            ]);

            $this->dispatch(DispatchType::Success, [
                'title' => 'Berhasil',
                'message' => 'Role berhasil di-update',
            ]);

        } else {

            Role::create([
                'name' => strtolower($this->role_name),
                'guard_name' => strtolower($this->guard_name),
            ]);

            $this->dispatch(DispatchType::Success, [
                'title' => 'Berhasil',
                'message' => 'Role berhasil di-tambahkan',
            ]);

            $this->role_name = "";
        }

        $this->emit('refresh-page');
    }
}
