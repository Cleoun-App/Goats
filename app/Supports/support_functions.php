<?php

use App\Exceptions\AppHandler;
use App\Models\Order;
use App\Models\Service;
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


if (function_exists("get_service") == false) {

    function get_service($id): Service
    {
        $service = Service::find($id);

        if ($service instanceof Service) {
            return $service;
        }

        throw new AppHandler("[Error]:[service] layanan tidak ditemukan");
    }
}

if (function_exists("get_order") == false) {

    function get_order($key): Order
    {
        $order = Order::where('key', $key)->first();

        if ($order instanceof Order) {
            return $order;
        }

        throw new AppHandler("[Error]:[order] pesanan tidak ditemukan!");
    }
}

if (function_exists("calculate_tax") == false) {

    function calculate_tax($amount)
    {
        return $amount + 5000;
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

if (function_exists("calculate_distance") == false) {

    function calculate_distance($lat1, $lon1, $lat2, $lon2): int
    {
        $earthRadius = 6371; // Radius of the Earth in kilometers

        // Convert latitude and longitude from degrees to radians
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        // Haversine formula
        $dLat = $lat2 - $lat1;
        $dLon = $lon2 - $lon1;
        $a = sin($dLat / 2) * sin($dLat / 2) + cos($lat1) * cos($lat2) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance; // Distance in kilometers
    }
}
