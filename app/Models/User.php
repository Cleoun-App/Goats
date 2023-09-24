<?php

namespace App\Models;

use App\Traits\User\Preferences;
use App\Traits\User\Utilities;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles;
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use Utilities;
    use Preferences;

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

        static::retrieved(function (User $user) {
            $user->photo_url = $user->image();
        });
        
        static::updating(function ($user){
            $user->offsetUnset('photo_url');
        });
    }
    
    /**
     *  Default key for user
     */
    public function username()
    {
        return "username";
    }


    public function goats() {
        return $this->hasMany(Goat::class, 'user_id');
    }

    public function group() {
        return $this->hasMany(Group::class, 'user_id');
    }

    public function events() {
        return $this->hasMany(Event::class, 'user_id');
    }

    public function milknote() {
        return $this->hasMany(MilkNote::class, 'user_id');
    }

}
