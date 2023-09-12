<?php

namespace App\Http\Livewire\Dashboard\AuthPage\LoginPage;

use App\Http\Livewire\Dashboard\_Dashboard;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginPage extends _Dashboard
{
    public $email, $password, $remember_me = false, $err_msg;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
        'remember_me' => 'required:boolean'
    ];

    public function render()
    {
        try {

            return view('livewire.dashboard.auth-page.login-page.login-page')->layout('layouts.auth');

            // ...
        } catch (\Throwable $th) {

            $this->onRenderError($th);
        }
    }

    /**
     *  Lakukan login
     *
     *  @return void
     */
    public function login()
    {
        try {

            $this->validate();

            $result = Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember_me);

            if ($result)
                redirect()->route('ds.home_page');


            $userExists = User::where('email', $this->email)->first();

            if (!$userExists) return $this->addError('email', 'Akun dengan email tersebut tidak di temukan!');

            $this->addError('password', 'Password anda tidak sesuai!');

            return;

            // ...
        } catch (\Throwable $th) {

            $this->onError($th);
        }
    }
}
