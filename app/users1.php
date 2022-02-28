<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class users1 extends Authenticatable
{
    use Notifiable;


    protected $table="users";
    protected  $fillable=['name','email','password','role'];


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
