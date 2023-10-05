<?php

use App\Exceptions\AppHandler;
use App\Models\Goat;
use App\Models\Group;
use App\Models\User;

if (function_exists("auth_user") == false) {

    function auth_user(): User
    {
        $user = auth()->user();

        if ($user instanceof User) {
            return $user;
        }

        throw new AppHandler("[Error]:[auth_user] terjadi kesalahn dalam pengambilan data user yang ter-autentikasi!!");
    }
}


if (function_exists("get_user") == false) {

    function get_user($username): User
    {
        $user = User::where('username', $username)->first();

        if ($user instanceof User) {
            return $user;
        }

        throw new AppHandler("[Error]:[auth_user] pengguna dengan username '$username' tidak ditemukan!");
    }
}

if (function_exists("get_group") == false) {

    function get_group($id): Group|null
    {
        $group = Group::find($id);

        if ($group instanceof Group) {
            return $group;
        }

        return null;
    }
}

if (function_exists("get_goat") == false) {

    function get_goat($tag, bool $throw_if_not_found = true): Goat|null
    {
        $goat = Goat::where('tag', $tag)->first();

        if ($goat instanceof Goat) {
            return $goat;
        }

        if($throw_if_not_found == false) {
            return null;
        }

        throw new AppHandler("[Error]:[goat] data kambing tidak ditemukan");
    }
}

if (function_exists("get_user_image") == false) {

    function get_user_image(?User $user)
    {
        if ($user instanceof User == false) {
            $user = auth()->user();
        }

        if ($user instanceof User) {
            return $user->image();
        }

        throw new AppHandler("[Error]:[get_user_image] data user tidak tersedia!!");
    }
}


if (function_exists("template_path") == false) {

    function template_path(?string $name): string
    {
        $I = DIRECTORY_SEPARATOR;

        $public_path = "{$I}storage{$I}templates{$I}test{$I}";

        return $public_path . $name;
    }
}


if (function_exists("calculate_order_price") == false) {

    function calculate_order_price($amount)
    {
        $amount = intval($amount);

        if($amount <= 0) {
            throw new \Exception("Price Amount Cannot Below 0");
        }

        return $amount + 15000;
    }
}

if (function_exists("money_format") == false) {

    function money_format($value): string
    {
        return "Rp. " . number_format($value, 0, ',', '.');
    }
}
