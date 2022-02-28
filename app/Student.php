<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

	protected $table="students";
    protected  $fillable=['first_name','last_name','image'];

    public function images()
    {
        return $this->hasMany(studentImage::class);
    }


}
