<?php

namespace App\Traits\User;

use App\Models\Preference;

trait Preferences
{
    /**
     *  Metode untuk mendapatkan user prefrensi
     */
    public function preferences()
    {
        return $this->belongsToMany(Preference::class, 'user_preferences', 'user_id', 'pref_id')->withPivot('value');
    }

    public function visualMode()
    {
        try {

            $prefrences = $this->preferences;

            $visual_pref = null;

            foreach ($prefrences as $pref) {
                if ($pref->key === 'visual.mode') {
                    $visual_pref = $pref;
                }
            }

            $isDarkMode = filter_var($visual_pref->pivot?->value ?? 0, FILTER_VALIDATE_BOOL);

            if ($isDarkMode == true) {
                return 'dark';
            }

            return 'light';

            // ...
        } catch (\Throwable $th) {

            return 'light';
        }
    }

}
