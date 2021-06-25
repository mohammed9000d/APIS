<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Doctor;
use App\Patient;
use App\Specialty;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    //
    public function getCounts()
    {
        //
        $doctors = Doctor::where('status', '=', 'Active')->take(5)->get();
        $patients = Patient::where('status', '=', 'Active')->take(5)->get();
        $appointments = Appointment::take(10)->get();
        $doctor_count = Doctor::count();
        $app_count = Appointment::count();
        $patient_count = Patient::count();
        $specialty_count = Specialty::count();

        return view('admin.dashboard',[
            'doctors'=>$doctors,
            'patients'=>$patients,
            'appointments'=>$appointments,
            'doctor_count'=>$doctor_count,
            'patient_count'=>$patient_count,
            'specialty_count'=>$specialty_count,
            'app_count'=>$app_count,
        ]);
    }
}
