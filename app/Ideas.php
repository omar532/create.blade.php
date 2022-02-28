<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ideas extends Model
{
    protected $table ='ideas';
    protected $fillable=['address','latitude','longitude','title','logo'];
}
