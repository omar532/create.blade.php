<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentImage extends Model
{
    protected $table ="tables_image";
    protected $fillable = ['student_id','path'];

}
