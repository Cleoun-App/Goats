<?php

namespace App\Traits\Rating;

use App\Models\Rating;
use Illuminate\Database\Eloquent\Model;

trait Rater
{
    public function rate(Model $model, int $rate)
    {

        $rating =  $this->rates()->where([
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
        ])->first();

        if($rating instanceof Rating) {
            return $rating->update(['rating' => $rate]);
        }

        $rating = new Rating();

        $rating->rating = $rate;
        $rating->user()->associate($this);
        $rating->model()->associate($model);

        return $rating->save();
    }

    public function rates()
    {
        return $this->hasMany(Rating::class);
    }
}
