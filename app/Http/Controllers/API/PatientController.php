<?php

namespace App\Http\Controllers\API;
use App\Patient;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource bw z NBVWGSDFGH0-Q.*
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $patients = Patient::all();
        return response()->json([
            'status'=>true,
            'message'=>'Success',
            'patients'=>$patients
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
        $validator = Validator($request->all(),  Patient::rolesPatient());
        if(!$validator->fails()){
           $patient = new Patient ();
           $patient->first_name = $request->get('first_name');
           $patient->last_name = $request->get('last_name');
           $patient->email = $request->get('email');
           $patient->mobile = $request->get('mobile');
           $patient->password = Hash::make('pass123$');
           $patient->state_id = $request->get('state_id');
           $patient->birth_date = $request->get('birth_date');
           $patient->gender = $request->get('gender');
           $patient->status = $request->has('status')?'Active':'InActive';
           $patient->blood_type = $request->get('blood_type');
           if ($request->hasFile('image')) {
            $patientImage = $request->file('image');
            $name = time() . '_' . $request->get('first_name') . '.' . $patientImage->getClientOriginalExtension();
            $patientImage->move('images/patient', $name);
            $patient->image = $name;
        }
           $isSaved = $patient->save();
           if($isSaved){
            return ControllerHelper::generateResponse(true,'Patient Created successfully');
           }else{
            return ControllerHelper::generateResponse(false,'Faled to create Patient');
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
        $validator = Validator::make($request->all(),['id' => 'required|exists:patients']);
        if(!$validator->fails()){
        $patient = Patient::find($id);
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $patient
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
        $validator = Validator($request->all(),  Patient::rolesPatient(),
        ['id'=> 'required|integer|exists:patients|unique:patients,email,'.$id,
        'id'=> 'required|integer|exists:patients|unique:patients,mobile,'.$id]);
        if(!$validator->fails()){
           $patient = Patient::findOrfail($id);
           $patient->first_name = $request->get('first_name');
           $patient->last_name = $request->get('last_name');
           $patient->email = $request->get('email');
           $patient->mobile = $request->get('mobile');
           $patient->password = Hash::make('pass123$');
           $patient->state_id = $request->get('state_id');
           $patient->birth_date = $request->get('birth_date');
           $patient->gender = $request->get('gender');
           $patient->status = $request->has('status')?'Active':'InActive';
           $patient->blood_type = $request->get('blood_type');
           if ($request->hasFile('image')) {
            $patientImage = $request->file('image');
            $name = time() . '_' . $request->get('first_name') . '.' . $patientImage->getClientOriginalExtension();
            $patientImage->move('images/patient', $name);
            $patient->image = $name;
        }
           $isSaved = $patient->save();
           if($isSaved){
            return ControllerHelper::generateResponse(true,'Patient Created successfully');
           }else{
            return ControllerHelper::generateResponse(false,'Faled to create Patient');
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
        $patient = Patient::findOrfail($id);
        $isDeleted = $patient->delete();
        if($isDeleted){
            return response()->json([
                'status'=>true,
                'message'=>'Deleted Patient Successfully'
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'Failed to deleted Patient!'
            ],400);
        }
    }
}
