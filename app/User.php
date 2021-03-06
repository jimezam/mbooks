<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'country_id', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function country()
    {
        return $this->belongsTo('App\Country');
    }
    
    public function mbooks()
    {
        return $this->hasMany('App\Mbook');
    }

    public function booksBookmarked()
    {
        return $this->belongsToMany('App\Mbook');
    }

    public function sheetsViewed()
    {
        return $this->belongsToMany('App\Msheet');
    }

    public function getNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }
}
