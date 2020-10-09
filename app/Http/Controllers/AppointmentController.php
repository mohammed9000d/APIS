<?php

namespace App\Http\Controllers;
use App\Appointment;
use App\Doctor;
use App\Patient;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $invoice = Appointment::with('invoice')->get();
        $appointments = Appointment::with('doctor.patient')->get();
        return view('admin.appointments.index',['appointments'=>$appointments],['invoice'=>$invoice]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $doctors = Doctor::where('status','=','Active')->get();
        $patients = Patient::where('status','=','Active')->get();
        return view('admin.appointments.create',['doctors'=>$doctors],['patients'=>$patients]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'doctor_id'=>'required|integer|exists:doctors,id',
            'patient_id'=>'required|integer|exists:patients,id',
            'date'=>'required|date',
            'start_time'=>'required',
            'end_time'=>'required',
            'duration_in_minutes'=>'required|integer',
            'price'=>'required',
            'details'=>'required|string',
            'status'=>'required'

        ]);
        $appointment =new Appointment();
        $appointment->doctor_id = $request->get('doctor_id');
        $appointment->patient_id = $request->get('patient_id');
        $appointment->start_time = $request->get('start_time');
        $appointment->end_time = $request->get('end_time');
        $appointment->duration_in_minutes = $request->get('duration_in_minutes');
        $appointment->price = $request->get('price');
        $appointment->details = $request->get('details');
        $appointment->status = $request->get('status');
        $appointment->date = $request->get('date');

        $isSaved = $appointment->save();
        if($isSaved){
            session()->flash('alert-type','alert-success');
            session()->flash('message','Appointment created successfully');
            return redirect()->back();
        }else{
            session()->flash('alert-type','alert-danger');
            session()->flash('message','Failed to create appointment!');
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $doctors = Doctor::where('status','=','Active')->get();
        $patients = Patient::where('status','=','Active')->get();
        $appointment = Appointment::findOrfail($id);
        return view('admin.appointments.edit', ['appointment'=>$appointment,'doctors'=>$doctors,'patients'=>$patients]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->request->add(['id'=>$id]);
        $request->validate([
            'id'=>'required|integer|exists:appointments',
            'doctor_id'=>'required|integer|exists:doctors,id',
            'patient_id'=>'required|integer|exists:patients,id',
            'date'=>'required|date',
            'start_time'=>'required',
            'end_time'=>'required',
            'duration_in_minutes'=>'required|integer',
            'price'=>'required',
            'details'=>'required|string',
            'status'=>'required'

        ]);
        $appointment = Appointment::find($id);
        $appointment->doctor_id = $request->get('doctor_id');
        $appointment->patient_id = $request->get('patient_id');
        $appointment->start_time = $request->get('start_time');
        $appointment->end_time = $request->get('end_time');
        $appointment->duration_in_minutes = $request->get('duration_in_minutes');
        $appointment->price = $request->get('price');
        $appointment->details = $request->get('details');
        $appointment->status = $request->get('status');
        $appointment->date = $request->get('date');

        $isupdated = $appointment->save();
        if($isupdated){
            session()->flash('alert-type','alert-success');
            session()->flash('message','Appointment updated successfully');
            return redirect()->back();
        }else{
            session()->flash('alert-type','alert-danger');
            session()->flash('message','Failed to update appointment!');
            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $isDeleted = Appointment::destroy($id);
        if($isDeleted){
            return response()->json([
                'title'=>'Success',
                'text'=>'Specialty deleted successfully',
                'icon'=>'success'
            ]);

        }else{
            return response()->json([
                'title'=>'Failed',
                'text'=>'Failed to delete Speciality',
                'icon'=>'error'
            ]);

            }
    }
}
