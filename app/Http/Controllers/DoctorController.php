<?php

namespace App\Http\Controllers;
use App\Doctor;
use App\City;
use App\Specialty;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $doctors = Doctor::with('specialty')->paginate(5);
        return view('admin.doctors.index',['doctors'=>$doctors]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $specialties = Specialty::where('status','=','Active')->get();
        $cities = City::with('states')->get();
        return view('admin.doctors.create',['cities'=>$cities],['specialties'=>$specialties]);
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
            'pricing'=>'required|string|in:Free,PerHour',
            'state_id'=>'required|integer|exists:states,id',
            'specialty_id'=>'required|integer|exists:specialties,id',
            'facebook_url'=>'required|string',
            'twitter_url'=>'required|string',
            'linked_in_url'=>'required|string',
            'first_name' => 'required|string|min:3|max:20',
            'last_name' => 'required|string|min:3|max:20',
            'email' => 'required|email|unique:doctors,email',
            'mobile' => 'required|numeric|unique:doctors,mobile',
            'gender' => 'required|string|in:Male,Female',
            'hour_price'=>'required|string',
            'image' => 'required|image',
            'about' => 'required|string',
            'status' => 'required|in:on',
            'birth_date' => 'required'
        ]);
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

        if($request->hasFile('image')){
            $ImageDoctor = $request->file('image');
            $ImageName = time(). '_' .$request->get('first_name'). '.' . $ImageDoctor->getClientOriginalExtension();
            $ImageDoctor->move('images/doctor',$ImageName);
            $doctor->image = $ImageName;
        }

        $isSaved = $doctor->save();
        if($isSaved){
            session()->flash('alert-type','alert-success');
            session()->flash('message','Doctor created successfully');
            return redirect()->back();
        }else{
            session()->flash('alert-type','alert-danger');
            session()->flash('message','Failed to create doctor!');
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
        $specialties = Specialty::where('status','=','Active')->get();
        $cities = City::with('states')->get();
        $doctor = Doctor::findOrfail($id);
        return view('admin.doctors.edit',['cities'=>$cities,'specialties'=>$specialties,'doctor'=>$doctor]);
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
            'id'=> 'required|integer|exists:doctors|unique:doctors,email,'.$id,
            'id'=> 'required|integer|exists:doctors|unique:doctors,mobile,'.$id,
            'pricing'=>'required|string|in:Free,PerHour',
            'state_id'=>'required|integer|exists:states,id',
            'specialty_id'=>'required|integer|exists:specialties,id',
            'facebook_url'=>'required|string',
            'twitter_url'=>'required|string',
            'linked_in_url'=>'required|string',
            'first_name' => 'required|string|min:3|max:20',
            'last_name' => 'required|string|min:3|max:20',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'gender' => 'required|string|in:Male,Female',
            'hour_price'=>'required|string',
            'image' => 'required|image',
            'about' => 'required|string',
            'status' => 'required|in:on',
            'birth_date' => 'required'
        ]);
        $doctor =Doctor::find($id);
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

        if($request->hasFile('image')){
            $ImageDoctor = $request->file('image');
            $ImageName = time(). '_' .$request->get('first_name'). '.' . $ImageDoctor->getClientOriginalExtension();
            $ImageDoctor->move('images/doctor',$ImageName);
            $doctor->image = $ImageName;
        }

        $isUpdated = $doctor->save();
        if($isUpdated){
            session()->flash('alert-type','alert-success');
            session()->flash('message','Doctor updated successfully');
            return redirect()->back();
        }else{
            session()->flash('alert-type','alert-danger');
            session()->flash('message','Failed to update doctor!');
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
    }
}
