<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    //
    public function state(){
        return $this->belongsTo(State::class,'state_id','id');
    }

    public function appointments(){
        return $this->hasMany(Appointment::class,'patient_id','id');
    }

    public function doctor(){
        return $this->belongsToMany(Doctor::class,Appointment::class,'patient_id','doctor_id');
    }
}
