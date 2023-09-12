<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\ValidUsername;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Utils\ResponseFormatter;
use App\Utils\Validations\UserValidation;
use Illuminate\Validation\ValidationException;

class RegistrationController extends Controller
{
    public function register(Request $request)
    {
        try {
            
            UserValidation::validateUserRegistration($request);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'creation_mark' => md5($request->username . now()),
             ]);

             if($user instanceof User) {
                $user->assignRole('customer');
             }

            return ResponseFormatter::success($user, "Registrasi berhasil");

            // ...
        } catch(ValidationException $e) {

            return ResponseFormatter::validasiError($e);

        } catch (\Throwable $th) {
            return ResponseFormatter::error([], $th->getMessage());
        }
    }
}
