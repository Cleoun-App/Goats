<?php

namespace App\Facades;

use Livewire\TemporaryUploadedFile;
use Intervention\Image\Facades\Image;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserFacade
{

    public static function store_photo(User $user, TemporaryUploadedFile $file): string
    {
        $encoder = 'jpeg';

        $filename = 'cover.jpeg';

        $image = Image::make($file);

        $image = $image->resize(800, 800)->encode($encoder, 80);

        $_path = self::create_user_photos_folder($user);

        $store_path = $_path . DIRECTORY_SEPARATOR . $filename;
        
        Storage::put($store_path, $image);

        return $filename;
    }

    /**
     *  Metode untuk membuat folder bagi user jika belum ada
     */
    public static function create_user_folder(User $user): string
    {
        $path = "users" . DIRECTORY_SEPARATOR .  $user->creation_mark;
        Storage::createDirectory($path);
        return $path;
    }

    /**
     *  Metode untuk membuat folder bagi user jika belum ada
     */
    public static function create_user_photos_folder(User $user)
    {

        $path = "users" . DIRECTORY_SEPARATOR .  $user->creation_mark;
        Storage::createDirectory($path);
        return $path;
    }
}
