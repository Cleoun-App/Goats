<?php

namespace App\Http\Livewire\Dashboard\AuthPage\RegistrationPage;

use App\Http\Livewire\Dashboard\_Dashboard;
use App\Http\Livewire\Dashboard\DispatchType;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RegistrationPage extends _Dashboard
{

    public $name, $username, $email, $phone_number, $password, $password_c, $privacy_policy;

    public function mount()
    {

        $fake = fake('id');
        $this->name = $fake->name;
        $this->username = $fake->username;
        $this->email = $fake->email;
        $this->phone_number = "082" . rand(10000000, 99999999);
        $this->password = 'password';
        $this->password_c = $this->password;
    }

    public function render()
    {
        try {

            return view('livewire.dashboard.auth-page.registration-page.registration-page')->layout('layouts.auth');;

            // ...
        } catch (\Throwable $th) {
            $this->onRenderError($th);
        }
    }


    public function register()
    {
        $this->validate([
            'name' => [
                'required',
                'min:4',
                'max:120',
            ],
            'username' => [
                'required',
                'min:3',
                'max:25',
                'regex:/^[a-zA-Z0-9._-]+$/'
            ],
            'phone_number' => [
                'required',
                'min:4',
                'numeric',
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'min:5',
                'max:24',
            ],
            'password_c' => [
                'same:password'
            ],
            'privacy_policy' => [
                'accepted'
            ]
        ]);


        try {

            $user_data = [
                'name'  =>  $this->name,
                'username' => $this->username,
                'phone_number' => $this->phone_number,
                'password' => Hash::make($this->password),
                'email' =>  $this->email,
                'creation_mark' => md5(time() . $this->username),
                'contacts' => [
                    'facebook' => '',
                    'instagram' => '',
                ],
            ];

            DB::beginTransaction();

            $result =  User::create($user_data);

            if ($result instanceof User) {
                $result->assignRole('customer');
            } else
                return $this->dispatch(DispatchType::Error, [
                    'title' => 'Gagal',
                    'message' => 'Mohon maaf, pendaftaran anda gagal silah coba beberapa saat lagi!!'
                ]);

            $this->dispatch(DispatchType::Success, [
                'title' => 'Berhasil',
                'message' => 'Pendaftaran Berhasil, silahkan login untuk melanjutkan'
            ]);


            session()->flash('success', 'Pendaftaran Berhasil, silahkan login untuk melanjutkan');

            $this->redirect(route('login'));

            DB::commit();

            // ....
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->onError($th);
        }
    }
}
