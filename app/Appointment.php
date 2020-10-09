<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //
    public function doctor(){
        return $this->belongsTo(Doctor::class,'doctor_id','id');
    }

    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id','id');
    }
    public function invoice(){
        return $this->hasOne(Invoice::class,'appointment_id','id');
    }
}
