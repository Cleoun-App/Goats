<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkNote extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function goat() {
        return $this->belongsTo(Goat::class, 'goat_id');
    }
}