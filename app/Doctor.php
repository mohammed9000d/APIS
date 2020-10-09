<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    //
    public function specialty(){
        return $this->belongsTo(Specialty::class,'specialty_id','id');
    }

    public function state(){
        return $this->belongsTo(State::class,'state_id','id');
    }
    public function appointments(){
        return $this->hasMany(Appointment::class,'doctor_id','id');
    }

    public function patient(){
        return $this->belongsToMany(Patient::class,Appointment::class,'doctor_id','patient_id');
    }
}
