<?php

namespace App\Utils\Validations;

use App\Models\User;
use App\Rules\ValidIndonesiaPhoneNumber;
use App\Rules\ValidUsername;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class UserValidation
{
    public static function validateUserRegistration(Request $request)
    {
        $message = array_merge(self::_name(true), self::_username(null, true),
        self::_email(null, true));

        $request->validate([
            'name' => self::_name(),
            'username' => self::_username(),
            'email' => self::_email(),
            'password' => [Password::min(5), Password::required(), 'max:60'],
            'confirm_password' => ['required', 'same:password'],
        ]);
    }

    public static function validateUpdateProfile(Request $request, User $user)
    {
        $request->validate([
            'name' => self::_name(),
            'username' => self::_username($user),
            'email' => self::_email($user),
            'gender' => ['required'],
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                File::image()->min(24)->max(3 * 1024),
            ],
        ]);
    }

    private static function _name(bool $isRule = true): array
    {
        if(!$isRule) {
            return [
                'name.required' => "Harap masukan nama anda!!",
                'name.min' => "Harap masukan nama minimal 4 karakter",
                'name.max' => "Harap masukan nama maximal 120 karakter",
                'name.regex' => "Nama yang anda masukan tidak valid!"
            ];
        }

        return [
            'required',
            'min:4',
            'max:120',
            "regex:/^[A-Za-z\s\-\'\.]+$/"
        ];
    }

    private static function _username(User $user = null, bool $isRule = true): array
    {
        if(!$isRule) {
            return [
                'username.required' => "Harap masukan 'username' anda!!",
                'username.min' => "Harap masukan 'username' minimal 4 karakter",
                'username.max' => "Harap masukan 'username' maximal 120 karakter",
                'username.unique' => "'Username' yang anda masukan telah digunakan, Masukan 'username' baru"
            ];
        }

        return [
            'required',
            'min:3',
            'max:25',
            'unique:users,username,' . $user?->id,
            new ValidUsername()
        ];
    }

    private static function _email(User $user = null, bool $isRule = true): array
    {
        if(!$isRule) {
            return [
                'email.required' => "Harap masukan 'email' anda!!",
                'email.email' => "'Email' yang anda masukan tidak valid!!",
                'email.unique' => "'Email' telah digunakan, Harap masukan email yang baru!!",
            ];
        }

        return [
            'required', 'email', 'unique:users,email,' . $user?->id
        ];
    }

    private static function _phonenumber(User $user = null, bool $isRule = true): array
    {
        if(!$isRule) {
            return [
                'phone_number.required' => "Harap masukan Nomor Telefon anda!!",
                'phone_number.email' => "Nomor Telefon yang anda masukan tidak valid!!",
                'phone_number.unique' => "Nomor Telefon telah digunakan, Harap masukan email yang baru!!",
            ];
        }

        return [
            'required', 'string', 'unique:users,phone_number,' . $user?->id,
            'between:10,12', new ValidIndonesiaPhoneNumber
        ];
    }
}
