<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    protected $table="users";
    protected  $fillable=['name','email','password'];

    public function isAdmin()
    {
        if($this->role ==   "admin")
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
