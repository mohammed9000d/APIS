<?php

namespace App\Http\Controllers\API;
use App\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource bw z NBVWGSDFGH0-Q.*
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $appointments = Appointment::all();
        return response()->json([
            'status'=>true,
            'message'=>'Success',
            'appointments'=>$appointments
            ]);
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
        $roles = [
            'doctor_id'=>'required|integer|exists:doctors,id',
            'patient_id'=>'required|integer|exists:patients,id',
            'date'=>'required|date',
            'start_time'=>'required',
            'end_time'=>'required',
            'duration_in_minutes'=>'required|integer',
            'price'=>'required',
            'details'=>'required|string',
            'status'=>'required'
        ];
        $validator = Validator($request->all(), $roles);
        if(!$validator->fails()){
           $appointment = new Appointment ();
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
            return ControllerHelper::generateResponse(true,'appointment Created successfully');

           }else{
            return ControllerHelper::generateResponse(false,'Faled to create appointment');
           }
        }else{
            return ControllerHelper::generateResponse(false,$validator->getMessageBag()->first());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
        $request->request->add(['id' => $id]);
        $validator = Validator::make($request->all(),['id' => 'required|exists:appointments']);
        if(!$validator->fails()){
        $appointment = Appointment::find($id);
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $appointment
        ]);
        }else{
            return ControllerHelper::generateResponse(false,$validator->getMessageBag()->first());
        }
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
        $roles = [
            'doctor_id'=>'required|integer|exists:doctors,id',
            'patient_id'=>'required|integer|exists:patients,id',
            'date'=>'required|date',
            'start_time'=>'required',
            'end_time'=>'required',
            'duration_in_minutes'=>'required|integer',
            'price'=>'required',
            'details'=>'required|string',
            'status'=>'required'
        ];
        $validator = Validator($request->all(), $roles);
        if(!$validator->fails()){
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
           $isSaved = $appointment->save();
           if($isSaved){
            return ControllerHelper::generateResponse(true,'appointment Created successfully');

           }else{
            return ControllerHelper::generateResponse(false,'Faled to create appointment');
           }
        }else{
            return ControllerHelper::generateResponse(false,$validator->getMessageBag()->first());
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
        $appointment = Appointment::findOrfail($id);
        $isDeleted = $appointment->delete();
        if($isDeleted){
            return response()->json([
                'status'=>true,
                'message'=>'Deleted appointment Successfully'
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'Failed to deleted appointment!'
            ],400);
        }
    }
}
