<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class userinvitation extends Authenticatable
{
    use Notifiable;


    protected $table="userinvitation";
    protected  $fillable=['name','email','password'];

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
        'password', 'remember',
    ];
}
