<?php

namespace App\Http\Controllers;

use App\Patient;
use Illuminate\Http\Request;
use App\City;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use PDO;
class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $patients = Patient::paginate(5);
        return view('admin.patients.index',['patients'=>$patients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $cities = City::with('states')->get();
        return view('admin.patients.create',['cities'=>$cities]);
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
            'state_id'=>'required|integer|exists:states,id',
            'first_name' => 'required|string|min:3|max:20',
            'last_name' => 'required|string|min:3|max:20',
            'email' => 'required|email|unique:patients,email',
            'mobile' => 'required|numeric|unique:patients,mobile',
            'gender' => 'required|string|in:Male,Female',
            'blood_type'=>'required|string',
            'image' => 'required|image',
            'status' => 'required|in:on',
        ]);
        $patient = new Patient();
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
            session()->flash('alert-type','alert-success');
            session()->flash('message','Patient created successfully');
            return redirect()->back();
        }else{
            session()->flash('alert-type','alert-danger');
            session()->flash('message','Failed to create patient');
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
        $cities = City::with('states')->get();
        $patient = Patient::findOrfail($id);
        return view('admin.patients.edit',['patient'=>$patient],['cities'=>$cities]);
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

        $request->request->add(['id'=>$id]);
        $request->validate([
            'id'=> 'required|integer|exists:patients|unique:patients,email,'.$id,
            'id'=> 'required|integer|exists:patients|unique:patients,mobile,'.$id,
            'state_id'=>'required|integer|exists:states,id',
            'first_name' => 'required|string|min:3|max:20',
            'last_name' => 'required|string|min:3|max:20',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'gender' => 'required|string|in:Male,Female',
            'blood_type'=>'required|string',
            'image' => 'required|image',
            'status' => 'required|in:on',
        ]);

        $patient = Patient::find($id);
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

        $isupdated = $patient->save();
        if($isupdated){
            session()->flash('alert-type','alert-success');
            session()->flash('message','Patient updated successfully');
            return redirect()->back();
        }else{
            session()->flash('alert-type','alert-danger');
            session()->flash('message','Failed to update patient');
            return redirect()->back();
        }
        dd(123);
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
        $isDeleted = Patient::destroy($id);
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
