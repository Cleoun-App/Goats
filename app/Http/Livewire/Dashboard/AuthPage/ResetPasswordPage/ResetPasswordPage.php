<?php

namespace App\Http\Livewire\Dashboard\AuthPage\ResetPasswordPage;

use App\Http\Livewire\Dashboard\_Dashboard;
use App\Http\Livewire\Dashboard\DispatchType;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordPage extends _Dashboard
{
    public $email;
    public $password;
    public $c_password;
    public $token;

    public function mount(Request $request)
    {
        $this->token = $request->token;
        $this->email = $request->email;
    }

    public function render()
    {

        $data['pageTitle'] = "Reset password";

        return view('livewire.dashboard.auth-page.reset-password-page.reset-password-page')
            ->layout('layouts.auth', $data);
    }

    public function resetPassword()
    {
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:3', 'max:50'],
            'c_password' => ['required', 'same:password'],
            'token' => ['required']
        ]);

        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'token' => $this->token,
            ],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(\Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
        ? $this->dispatch(DispatchType::Success, [
            'title' =>  'Berhasil',
            'message' => 'Password berhasil di-reset',])
        : $this->dispatch(DispatchType::Error, [
            'title' =>  'Gagal',
            'message' => 'Password gagal di-reset',]);
    }

}
