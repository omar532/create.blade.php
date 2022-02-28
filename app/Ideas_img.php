<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ideas_img extends Model
{
    protected $table ='ideas_img';
    protected $fillable=['ideas_id','path'];
}
