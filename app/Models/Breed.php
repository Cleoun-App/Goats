<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Breed extends Model
{
    use HasFactory;

    public function goats(User $user = null) {
        return $this->hasMany(Goat::class, "breed", "name");
    }
}
