<?php

namespace App\Http\Livewire\Dashboard\Components\TopBar;

use App\Http\Livewire\Dashboard\_Dashboard;

class TopBar extends _Dashboard
{
    public function render()
    {
        try {

            $data['user'] = auth_user();

            return view('livewire.dashboard.components.top-bar.top-bar', $data);

            // ...
        } catch (\Throwable $th) {
            $this->onRenderError($th);
        }
    }
}
