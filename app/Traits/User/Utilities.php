<?php

namespace App\Traits\User;

use Illuminate\Support\Facades\File;


trait Utilities
{
    /**
     *  Metode untuk mendapatkan gambar profil
     *
     *  @return string
     */
    public function image()
    {
        if (empty($this->profile_photo)) {
            return asset('assets/images/default.png');
        }

        return asset($this->profile_photo);

    }

    /**
     *  Metode untuk mendapatkan folder user
     *
     *  @deprecated
     */
    public function get_user_public_folder(string $string = ""): string
    {
        return "users" . DIRECTORY_SEPARATOR .  $this->creation_mark . DIRECTORY_SEPARATOR  . $string;
    }

    /**
     *  Metode untuk mendapatkan path user di dalam directory
     *  secara general
     *
     */
    public function path(string $string = ""): string
    {
        return "users" . DIRECTORY_SEPARATOR .  $this->creation_mark . DIRECTORY_SEPARATOR  . $string;
    }
    
    /**
     *  Metode untuk mendapatkan directory photo
     */
    public function get_photo_public_folder(): string
    {
        return $this->get_user_public_folder();
    }
    
    /**
     * Metode untuk mendapatkan direktori storage user
     */
    public function get_storage(string $string = "")
    {
        $i = DIRECTORY_SEPARATOR;

        $path = storage_path("app{$i}users" . $i . $this->creation_mark . $i . $string);

        if(!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        return $path;

    }

}
