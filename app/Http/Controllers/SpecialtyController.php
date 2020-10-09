<?php

namespace App\Http\Controllers;

use App\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $specialties = Specialty::all();
        return view('admin.specialties.index',['specialties'=>$specialties]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.specialties.create');
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
            'title_en' => 'required|string|min:3|max:20',
            'description_en' => 'required|string|min:5|max:100',
            'image' => 'required|image',
            'status' => 'in:on'
        ]);
        $specialty = new Specialty();
        $specialty->title_en = $request->get('title_en');
        $specialty->description_en = $request->get('description_en');
        $specialty->status = $request->has('status') ? 'Active':'InActive';

        if($request->hasFile('image')){
            $specialtyImage = $request->file('image');
            $ImageName = time().'_'. $request->get('title_en').'.'. $specialtyImage->getClientOriginalExtension();
            $specialtyImage->move('images/specialty',$ImageName);
            $specialty->image = $ImageName;
        }
        $isSaved = $specialty->save();
        if($isSaved){
            session()->flash('alert-type','alert-success');
            session()->flash('message','Specialty created successfully');
            return redirect()->back();
        }else{
            session()->flash('alert-type','alert-danger');
            session()->flash('message','Failed to create specialty!');
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
        $specialty = Specialty::findOrfail($id);
        return view('admin.specialties.edit',['specialty'=>$specialty]);
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
            'id' => 'required|string|exists:specialties,id',
            'title_en' => 'required|string|min:3|max:20',
            'description_en' => 'required|string|min:5|max:100',
            'image' => 'required|image',
            'status' => 'required'
        ]);
        $specialty =Specialty::find($id);
        $specialty->title_en = $request->get('title_en');
        $specialty->description_en = $request->get('description_en');
        $specialty->status = $request->has('status') ? 'Active':'InActive';

        if($request->hasFile('image')){
            $specialtyImage = $request->file('image');
            $ImageName = time().'_'. $request->get('title_en').'.'. $specialtyImage->getClientOriginalExtension();
            $specialtyImage->move('images/specialty',$ImageName);
            $specialty->image = $ImageName;
        }
        $isUpdate = $specialty->save();
        if($isUpdate){
            session()->flash('alert-type','alert-success');
            session()->flash('message','Specialty updated successfully');
            return redirect()->back();
        }else{
            session()->flash('alert-type','alert-danger');
            session()->flash('message','Failed to update specialty!');
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
        $isDeleted = Specialty::destroy($id);
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
