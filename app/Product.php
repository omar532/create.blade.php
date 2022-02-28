<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table="students";
    protected  $fillable=['first_name','last_name','image'];


}
