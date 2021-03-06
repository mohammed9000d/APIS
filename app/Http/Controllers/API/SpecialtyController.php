<?php

namespace App\Http\Controllers\API;
use App\Specialty;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpecialtyController extends Controller
{
    /**
     * Display a listing of the resource bw z NBVWGSDFGH0-Q.*
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $specialties = Specialty::all();
        return response()->json([
            'status'=>true,
            'message'=>'Success',
            'specialties'=>$specialties
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
            'title_en' => 'required|string|min:3|max:20',
            'description_en' => 'required|string|min:5|max:100',
            'image' => 'required|image',
            'status' => 'in:on'
        ];
        $validator = Validator($request->all(), $roles);
        if(!$validator->fails()){
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
            return ControllerHelper::generateResponse(true,'specialty Created successfully');

           }else{
            return ControllerHelper::generateResponse(false,'Faled to create specialty');
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
        $validator = Validator::make($request->all(),['id' => 'required|exists:specialties']);
        if(!$validator->fails()){
        $specialty = Specialty::find($id);
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $specialty
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
            'id' => 'required|integer|exists:specialties,id',
            'title_en' => 'required|string|min:3|max:20',
            'description_en' => 'required|string|min:5|max:100',
            'image' => 'required|image',
            'status' => 'in:on'
        ];
        $validator = Validator($request->all(), $roles);
        if(!$validator->fails()){
            $specialty = Specialty::findOrfail($id);
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
            return ControllerHelper::generateResponse(true,'specialty updated successfully');

           }else{
            return ControllerHelper::generateResponse(false,'Faled to update specialty');
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
        $specialty = Specialty::findOrfail($id);
        $isDeleted = $specialty->delete();
        if($isDeleted){
            return response()->json([
                'status'=>true,
                'message'=>'Deleted specialty Successfully'
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'Failed to deleted specialty!'
            ],400);
        }
    }
}
