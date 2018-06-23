<?php

namespace chickenhead\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'provider', 'provider_id'
    ];

    public function likes(){
      return $this->belongsToMany( 'chickenhead\Models\Cafe', 'users_cafes_likes', 'user_id', 'cafe_id');
    }

    public function cafePhotos(){
      return $this->hasMany( 'chickenhead\Models\CafePhoto', 'id', 'cafe_id' );
    }
}
