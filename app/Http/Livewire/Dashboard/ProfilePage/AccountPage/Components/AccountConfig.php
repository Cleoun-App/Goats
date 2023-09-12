<?php

namespace App\Http\Livewire\Dashboard\ProfilePage\AccountPage\Components;

use App\Http\Livewire\Dashboard\_Dashboard;
use App\Http\Livewire\Dashboard\DispatchType;

class AccountConfig extends _Dashboard
{

    public $username;

    public $vs_mode;

    public function mount()
    {
        $user = auth_user();

        $this->username = $user->username;

        $preferences = $user->preferences;

        foreach ($preferences as $preference) {
            if ($preference->key === "visual.mode") {
                $this->vs_mode = filter_var($preference->pivot->value, FILTER_VALIDATE_BOOL);
            }
        }
    }

    public function render()
    {
        try {

            return view('livewire.dashboard.profile-page.account-page.components.account-config');

            // ...
        } catch (\Throwable $th) {
            $this->onRenderError($th);
        }
    }

    public function updateConfig()
    {
        try {

            $user = auth_user();

            $user->preferences()->sync([
                '1' => ['value' => $this->vs_mode],
            ], false);
           
            return $this->dispatch(DispatchType::Success, [
                'title'  =>  'Success',
                'message' => 'Konfigurasi berhasil di-update'
            ]);
        } catch (\Throwable $th) {
            return $this->dispatch(DispatchType::Error, [
                'title'  =>  'Error',
                'message' => $this->filterMessage($th),
            ]);
        }
    }
}
