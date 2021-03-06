<?php

namespace App\Http\Controllers\API;
use App\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource bw z NBVWGSDFGH0-Q.*
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $doctors = Doctor::all();
        return response()->json([
            'status'=>true,
            'message'=>'Success',
            'doctors'=>$doctors
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
        $validator = Validator($request->all(),  Doctor::rolesDoctor());
        if(!$validator->fails()){
           $doctor = new Doctor();
           $doctor->first_name = $request->get('first_name');
           $doctor->last_name = $request->get('last_name');
           $doctor->email = $request->get('email');
           $doctor->mobile = $request->get('mobile');
           $doctor->birth_date = $request->get('birth_date');
           $doctor->password = Hash::make('pass123$');
           $doctor->gender = $request->get('gender');
           $doctor->pricing = $request->get('pricing');
           $doctor->hour_price = $request->get('hour_price');
           $doctor->status = $request->has('status')?'Active':'InActive';
           $doctor->facebook_url = $request->get('facebook_url');
           $doctor->twitter_url = $request->get('twitter_url');
           $doctor->linked_in_url = $request->get('linked_in_url');
           $doctor->state_id = $request->get('state_id');
           $doctor->specialty_id = $request->get('specialty_id');
           $doctor->about = $request->get('about');

           if ($request->hasFile('image')) {
            $doctorImage = $request->file('image');
            $name = time() . '_' . $request->get('first_name') . '.' . $doctorImage->getClientOriginalExtension();
            $doctor->move('images/doctor', $name);
            $doctor->image = $name;
        }
           $isSaved = $doctor->save();
           if($isSaved){
            return ControllerHelper::generateResponse(true,'doctor Created successfully');
           }else{
            return ControllerHelper::generateResponse(false,'Faled to create doctor');
           }
        }else{
            return ControllerHelper::generateResponse(false,$validator->getMessageBag());
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
        $validator = Validator::make($request->all(),['id' => 'required|exists:doctors']);
        if(!$validator->fails()){
        $doctor = Doctor::find($id);
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $doctor
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
        $validator = Validator($request->all(),  Doctor::rolesDoctor(),
        ['id'=> 'required|integer|exists:doctors|unique:doctors,email,'.$id,
        'id'=> 'required|integer|exists:doctors|unique:doctors,mobile,'.$id]);
        if(!$validator->fails()){
           $doctor = Doctor::find($id);
           $doctor->first_name = $request->get('first_name');
           $doctor->last_name = $request->get('last_name');
           $doctor->email = $request->get('email');
           $doctor->mobile = $request->get('mobile');
           $doctor->birth_date = $request->get('birth_date');
           $doctor->password = Hash::make('pass123$');
           $doctor->gender = $request->get('gender');
           $doctor->pricing = $request->get('pricing');
           $doctor->hour_price = $request->get('hour_price');
           $doctor->status = $request->has('status')?'Active':'InActive';
           $doctor->facebook_url = $request->get('facebook_url');
           $doctor->twitter_url = $request->get('twitter_url');
           $doctor->linked_in_url = $request->get('linked_in_url');
           $doctor->state_id = $request->get('state_id');
           $doctor->specialty_id = $request->get('specialty_id');
           $doctor->about = $request->get('about');

           if ($request->hasFile('image')) {
            $doctorImage = $request->file('image');
            $name = time() . '_' . $request->get('first_name') . '.' . $doctorImage->getClientOriginalExtension();
            $doctor->move('images/doctor', $name);
            $doctor->image = $name;
        }
           $isSaved = $doctor->save();
           if($isSaved){
            return ControllerHelper::generateResponse(true,'doctor Created successfully');
           }else{
            return ControllerHelper::generateResponse(false,'Faled to create doctor');
           }
        }else{
            return ControllerHelper::generateResponse(false,$validator->getMessageBag());
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
        $doctor = Doctor::findOrfail($id);
        $isDeleted = $doctor->delete();
        if($isDeleted){
            return response()->json([
                'status'=>true,
                'message'=>'Deleted doctor Successfully'
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'Failed to deleted doctor!'
            ],400);
        }
    }
}
