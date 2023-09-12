<?php

namespace App\Http\Livewire\Dashboard\HomePage;

use App\Http\Livewire\Dashboard\_Dashboard;

class HomePage extends _Dashboard
{
    public function render()
    {
        try {

            $data['user'] = auth()->user();
            $data['pageTitle'] = "Dashboard";

            return view('livewire.dashboard.home-page.home-page')
                ->layout('layouts.app', $data);

            // ...
        } catch (\Throwable $th) {
            $this->onRenderError($th);
        }
    }
}
