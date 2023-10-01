<?php

namespace App\Http\Livewire\Dashboard\UserPages\UserCreatePage;

use App\Http\Livewire\Dashboard\_Dashboard;
use App\Http\Livewire\Dashboard\DispatchType;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserCreatePage extends _Dashboard
{
    public $pageTitle = "Tambahkan Pengguna";

    public $section_active = 0;

    public $sect_title;
    public $sect_subtitle;
    public $form_title;

    // user data
    public $email;
    public $name;
    public $role = 'User';
    public $username;
    public $address;
    public $password;
    public $c_password;

    public $section = [
        [
            'title' => "Informasi Akun",
            'subtitle' => 'Silahkan isi form informasi di bawah',
            'form_title' => "Masukan Informasi Anda",
        ],
        [
            'title' => "Privasi Akun",
            'subtitle' => 'Silahkan masukan password untuk akun anda!',
            'form_title' => "Masukan Password Anda",
        ],
    ];

    public function mount()
    {
        $this->pushBread(1, $this->pageTitle);
        $this->assingSectHeader($this->section_active);

        $faker = fake();

        $this->email = $faker->email();
        $this->name = $faker->name();
        $this->address = $faker->address();
        $this->password = 'password';
        $this->c_password = 'password';
    }

    public function render()
    {
        try {

            $data['user']   =   auth_user();
            $data['posts']  =   [];

            return view('livewire.dashboard.user-pages.user-create-page.user-create-page', $data)
                ->layout('layouts.app', ['pageTitle' => $this->pageTitle]);

            // ...
        } catch (\Throwable $th) {
            $this->onRenderError($th);
        }
    }

    public function goto(int $index)
    {
        if($index >= count($this->section) || $index < 0) {
            return;
        }

        // $this->dispatch(DispatchType::Success, ['title' => 'Hallo', 'msg' => 'asas']);

        $this->section_active = $index;
        $this->assingSectHeader($index);
    }

    public function assingSectHeader($index)
    {
        $data = $this->section[$index];

        $this->sect_title = $data['title'];
        $this->sect_subtitle = $data['subtitle'];
        $this->form_title = $data['form_title'];
    }

    public function addUser()
    {
        try {

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
                'c_password' => [
                    'same:password'
                ],
                'role' => [
                    'required'
                ],
            ]);

        } catch (\Throwable $th) {
            $this->dispatch(DispatchType::Error, [
                'title' => 'Validasi Error!',
                'message' => $th->getMessage(),
            ]);
            throw $th;
        }


        try {

            $user_data = [
                'name'  =>  $this->name,
                'username' => $this->username,
                'password' => Hash::make($this->password),
                'email' =>  $this->email,
                'creation_mark' => md5(time() . $this->username),
            ];

            $result =  User::create($user_data);

            if ($result instanceof User) {
                $result->assignRole($this->role);
            } else {
                return $this->dispatch(DispatchType::Error, [
                    'title' => 'Gagal',
                    'message' => 'Pengguna Gagal Di Tambahkan'
                ]);
            }

            $this->dispatch(DispatchType::Success, [
                'title' => 'Berhasil',
                'message' => 'Pengguna Berhasil Di Tambahkan',
            ]);

            $this->resetExcept("");

            // ....
        } catch (\Throwable $th) {
            return $this->onError($th);
        }
    }
}
