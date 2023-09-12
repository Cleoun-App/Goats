<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\File;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles;
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
    * The attributes that should be hidden for serialization.
    *
    * @var string
    */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'creation_mark',
        'phone_number',
        'address',
        'location',
        'profile_photo',
        'pin',
        'gender',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'location' => 'array',
    ];

    /**
     *  With
     */
    protected $with = [
        'roles',
    ];

    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($user) {
            $user->profile_photo = $user->image();
        });
    }
    
    /**
     *  Default key for user
     */
    public function username()
    {
        return "username";
    }


    /**
     *  Metode untuk mendapatkan gambar profil
     *
     *  @return string
     */
    public function image()
    {
        if (empty($this->profile_photo)) {
            return asset('assets/images/default.png');
        }

        return asset($this->profile_photo);

    }

    /**
     *  Metode untuk mendapatkan folder user
     *
     *  @deprecated
     */
    public function get_user_public_folder(string $string = ""): string
    {
        return "users" . DIRECTORY_SEPARATOR .  $this->creation_mark . DIRECTORY_SEPARATOR  . $string;
    }

    /**
     *  Metode untuk mendapatkan path user di dalam directory
     *  secara general
     *
     */
    public function path(string $string = ""): string
    {
        return "users" . DIRECTORY_SEPARATOR .  $this->creation_mark . DIRECTORY_SEPARATOR  . $string;
    }

    /**
     * Metode untuk mendapatkan direktori storage user
     */
    public function get_storage(string $string = "")
    {
        $i = DIRECTORY_SEPARATOR;

        $path = storage_path("app{$i}users" . $i . $this->creation_mark . $i . $string);

        if(!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        return $path;

    }

    /**
     *  Metode untuk mendapatkan directory photo
     */
    public function get_photo_public_folder(): string
    {
        return $this->get_user_public_folder();
    }

    /**
     *  Metode untuk mendapatkan user prefrensi
     */
    public function preferences()
    {
        return $this->belongsToMany(Preference::class, 'user_preferences', 'user_id', 'pref_id')->withPivot('value');
    }

    public function getProfilePhotoPathAttribute()
    {
        return "";
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
