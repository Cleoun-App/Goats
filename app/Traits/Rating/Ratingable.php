<?php

namespace App\Traits\Rating;

use App\Models\Rating;

trait Ratingable
{
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'model');
    }
}
