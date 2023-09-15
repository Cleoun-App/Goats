<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utils\ResponseFormatter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Utils\Validations\UserValidation;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            
            $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);
            
            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials)) {

                $user = auth_user();

                $token = $user->createToken('authToken')->plainTextToken;

                return ResponseFormatter::success([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'expires_in' => config('sanctum.expiration'),
                    'user' => $user,
                ], 'Login Berhasil');
            } else {
                return ResponseFormatter::error([
                    'phone_number' =>  $request->phone_number,
                    'password' => $request->password,
                ], 'Pastikan Nomor Telepon dan Password anda benar!!', 200);
            }
        } catch(ValidationException $e) {

            return ResponseFormatter::error(
                $e->validator->getMessageBag(),
                $e->getMessage()
            );

        }  catch (\Throwable $th) {
            return ResponseFormatter::error([
                'phone_number' =>  $request->phone_number,
                'password' => $request->password,
            ], $th->getMessage(), 400);
        }
    }

    public function change_password(Request $request) {
        try {
            
            $request->validate([
                'username' => ['required'],
                'new_password' => ['required', 'min:5', 'max:120'],
                'password_confirm' => ['required', 'same:new_password'],
                'old_password' => ['required'],
            ]);

            $user = get_user($request->username);

            if(Hash::make($request->old_password) != $user->password) {
                throw new \Exception("Password lama anda tidak sesuai!!");
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return ResponseFormatter::success("Password berhasil di-ubah!");
            
        } catch (\Throwable $th) {
            return ResponseFormatter::error([
                'phone_number' =>  $request->phone_number,
                'password' => $request->password,
            ], $th->getMessage(), 200);
        }
    } 

    
    public function register(Request $request)
    {
        try {
            
            UserValidation::validateUserRegistration($request);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'creation_mark' => md5($request->username . now()),
             ]);

             if($user instanceof User) {
                $user->assignRole('user');
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
