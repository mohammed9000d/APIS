<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    //
    public function doctors(){
    return $this->hasMany(Doctor::class,'specialty_id','id');
}

}
