<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breadcrumb extends Model
{
    use HasFactory;

    public static function set($name, $route) {
        
        $br = session('br');

        if(is_array($br) == false) $br = [];

        $br[] = ['name' => $name, 'route' => $route];

        session('br', $br);

    }
}
