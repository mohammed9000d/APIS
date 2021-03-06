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

    public static function rolesPatient(){
        $roles = [
            'state_id'=>'required|integer|exists:states,id',
            'first_name' => 'required|string|min:3|max:20',
            'last_name' => 'required|string|min:3|max:20',
            'email' => 'required|email|unique:patients,email',
            'mobile' => 'required|numeric|unique:patients,mobile',
            'gender' => 'required|string|in:Male,Female',
            'blood_type'=>'required|string',
            'image' => 'required|image',
            'status' => 'required',
        ];

        return $roles ;
    }
}
