<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    public function states(){
        return $this->hasMany(State::class,'city_id','id');
    }

}
