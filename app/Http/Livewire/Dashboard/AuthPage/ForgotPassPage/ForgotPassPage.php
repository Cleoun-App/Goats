<?php

namespace App\Http\Livewire\Dashboard\AuthPage\ForgotPassPage;

use App\Http\Livewire\Dashboard\_Dashboard;
use App\Http\Livewire\Dashboard\DispatchType;
use App\Models\User;
use Illuminate\Support\Facades\Password;

class ForgotPassPage extends _Dashboard
{
    public $email;

    public function render()
    {
        try {

            $data['pageTitle'] = "Lupa password";
            
            return view('livewire.dashboard.auth-page.forgot-pass-page.forgot-pass-page')
                ->layout('layouts.auth', $data);
            
            // ...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function sendLink() {
        $this->validate([
            'email' => ['required', 'email']
        ]);

        if(User::where('email', '=', $this->email)->first() instanceof User === false) {
            return $this->dispatch(DispatchType::Error, [
                'title' =>  'Gagal',
                'message' => 'Email yang anda masukan tidak ditemukan!',
            ]);
        }

        $status = Password::sendResetLink(['email' => $this->email]);

        if($status === Password::RESET_LINK_SENT) {
            return $this->dispatch(DispatchType::Success, [
                'title' =>  'Berhasil',
                'message' => 'Link berhasil di kirim ke email',
            ]);
        }

        return $this->dispatch(DispatchType::Error, [
            'title' =>  'Gagal',
            'message' => 'Gagal mengirim ke email' ,
        ]);
    }
}
