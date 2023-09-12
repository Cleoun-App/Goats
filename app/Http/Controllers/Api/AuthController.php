<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utils\ResponseFormatter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            
            $request->validate([
                'phone_number' => 'required',
                'password' => 'required',
            ]);
            
            $credentials = $request->only('phone_number', 'password');

            if (Auth::attempt($credentials)) {
                $user = auth()->user();
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

    public function change_password($request) {
        try {
            
            $request->validate([
                'username' => ['required'],
                'new_password' => ['required', 'min:5', 'max:120'],
                'password_confirm' => ['required', 'same:new_password'],
                'old_password' => ['required'],
            ]);

            $user = User::where('username', $request->username)->firstOrFail();

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
}
