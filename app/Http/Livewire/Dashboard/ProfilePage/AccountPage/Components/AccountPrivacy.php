<?php

namespace App\Http\Livewire\Dashboard\ProfilePage\AccountPage\Components;

use App\Http\Livewire\Dashboard\_Dashboard;
use App\Http\Livewire\Dashboard\DispatchType;
use Illuminate\Support\Facades\Hash;

class AccountPrivacy extends _Dashboard
{
    public $password, $password_new, $password_confirm;

    public function render()
    {
        try {

            return view('livewire.dashboard.profile-page.account-page.components.account-privacy');

            // ...
        } catch (\Throwable $th) {
            return $this->onRenderError($th);
        }
    }

    /**
     *  Metode update password
     */
    public function updatePassword()
    {
        try {

            $user = auth_user();

            $this->validate([
                'password' => [
                    'required',
                    function ($attribut, $value, $fail) use ($user) {
                        if (Hash::check($value, $user->password) == false) {
                            $fail("Password yang anda masukan salah!");
                        }
                    }
                ],
                'password_new' => [
                    'required', 'min:3', 'max:30',
                    function ($attribut, $value, $fail) use ($user) {
                        if (Hash::check($value, $user->password)) {
                            $fail("Password yang anda masukan sama dengan password sebelumnya!");
                        }
                    },
                ],
                'password_confirm' => ['same:password_new'],
            ], [
                'password.required' => 'Harap masukan password!',
                'password_new.required' => 'Harap masukan password yang baru',
                'password_new.min' => 'Password yang anda masukan minimal 3 karakter',
                'password_new.max' => 'Password yang anda masukan melebihi 30 karakter',
                'password_confirm.same' => 'Password yang anda masukan tidak sesuai dengan password baru anda!',
            ]);

            $password = Hash::make($this->password_new);
            
            $user->password = $password;

            $user->save();
            
            $this->dispatch(DispatchType::Success, [
                'title' => 'Berhasil',
                'message' => 'Password berhasil di ubah ',
            ]);

            // ...
        } catch (ValidationException $ve) {
            throw $ve;
        } catch (\Throwable $th) {

            throw $th;

            $this->dispatch(DispatchType::Error, [
                'title' => 'Error',
                'message' => $this->filterMessage($th),
            ]);
        }
    }
}
