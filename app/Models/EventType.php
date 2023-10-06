<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'field' => 'array'
    ];

    public function events() {
        return $this->hasMany(Event::class, 'type', 'name');
    }

    public function events_list() {
        
    }
}
