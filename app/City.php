<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    // protected $guarded = [];
    public function states(){
        return $this->hasMany(State::class,'city_id','id');
    }

}
