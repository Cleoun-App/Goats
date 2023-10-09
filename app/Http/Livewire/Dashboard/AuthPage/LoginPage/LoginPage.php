<?php

namespace App\Http\Livewire\Dashboard\AuthPage\LoginPage;

use App\Http\Livewire\Dashboard\_Dashboard;
use App\Http\Livewire\Dashboard\DispatchType;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

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


            if ($result) {
                
                $user = auth_user();
                
                $role = $user->roles()->where('name', 'admin')->first();

                if($role instanceof Role === false) {

                    $this->dispatch(DispatchType::Error,[
                        'title' => "Autorisasi Gagal",
                        'message' => "Pengguna tidak dapat login ke web ini"
                    ]);

                    auth()->logout();

                    return;

                }

                redirect()->route('ds.home_page');
            }


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
