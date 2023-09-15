<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goat extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function event() {
        return $this->hasMany(Event::class);
    }

    public function group() {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function father() {
        return $this->belongsTo(Goat::class, 'father_id');
    }
    
    public function mother() {
        return $this->belongsTo(Goat::class, 'mother_id');
    }

    public function milknote() {
        return $this->hasMany(MilkNote::class, 'goat_id');
    }
}
