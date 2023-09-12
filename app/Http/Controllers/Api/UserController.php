<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\ResponseFormatter;
use App\Utils\Validations\UserValidation;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function getUser($username)
    {
        try {

            // throw new \Exception($username);

            $user = User::where('username', '=', $username)->firstOrFail();

            return ResponseFormatter::success($user, 'Data user berhhasil di dapatkan');

        } catch (\Throwable $th) {

            return ResponseFormatter::error($th->getMessage(), 'Data user gagal di dapatkan');
        }
    }

    public function deleteUser($id)
    {
        try {

            $user = User::find($id);

            if($user instanceof User === false) {
                throw new \Exception('Pengguna tidak ditemukan');
            }

            $user->delete();

            return ResponseFormatter::success($user, 'Data pengguna berhhasil dihapus!');

        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());
        }
    }

    public function editUser($username)
    {
        try {
            
            $request = request();
            
            $user = User::where('username', $username)->first();

            if($user instanceof User) {

                UserValidation::validateUpdateProfile($request, $user);
                
                $storage = $user->get_storage();

                $filename = md5($request->name . "-" . uniqid() . '-' . time()) . ".jpg";

                $user_folder = $storage . DIRECTORY_SEPARATOR ;
    
                if(!FacadesFile::exists($user_folder)) {
                    FacadesFile::makeDirectory($user_folder);
                }
    
                Image::make($request->image)->save("$user_folder$filename", 80, 'jpg');

                
                $user->update([
                    'profile_photo' => $filename, 
                    'name' => $request->name,
                    'username' => $request->username,
                    'email' => $request->email,
                    'location' => $request->location,
                    'province' => $request->province,
                    'regency' => $request->regency,
                    'district' => $request->district,
                    'village' => $request->village,
                    'postal_code' => $request->postal_code,
                    'gender' => $request->gender,
                    'address' => $request->address,
                ]);

                return ResponseFormatter::success($user, "Data pengguna berhasil diubah!");
    
                // ...
            } else {
                throw new \Exception('Pengguna dengan username ' . $username . ' tidak ditemukan!');
            }

        } catch(ValidationException $e) {

            return ResponseFormatter::error(
                $e->validator->getMessageBag(),
                $e->getMessage()
            );

        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());
        }
    }

}
