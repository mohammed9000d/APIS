<?php

namespace App\Http\Controllers\API;
use App\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource bw z NBVWGSDFGH0-Q.*
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $admins = Admin::all();
        return response()->json([
            'status'=>true,
            'message'=>'Success',
            'admins'=>$admins
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
            'state_id'=>'required|integer|exists:states,id',
            'first_name' => 'required|string|min:3|max:10',
            'last_name' => 'required|string|min:3|max:10',
            'email' => 'required|email|unique:admins,email',
            'mobile' => 'required|numeric|unique:admins,mobile',
            'gender' => 'required|string|in:Male,Female',
            'image' => 'required|image',
            'status' => 'required|in:on',
        ];
        $validator = Validator($request->all(), $roles);
        if(!$validator->fails()){
            $admin = new Admin();
            $admin->first_name = $request->get('first_name');
            $admin->last_name = $request->get('last_name');
            $admin->email = $request->get('email');
            $admin->mobile = $request->get('mobile');
            $admin->password = Hash::make('pass123$');
            $admin->state_id = $request->get('state_id');
            $admin->birth_date = $request->get('birth_date');
            $admin->gender = $request->get('gender');
            $admin->status = $request->has('status')?'Active':'InActive';

            if ($request->hasFile('image')) {
                $adminImage = $request->file('image');
                $name = time() . '_' . $request->get('first_name') . '.' . $adminImage->getClientOriginalExtension();
                $adminImage->move('images/admin', $name);
                $admin->image = $name;
            }
            $isSaved = $admin->save();
            if($isSaved){
                return ControllerHelper::generateResponse(true,'admin Created successfully');

            }else{
                return ControllerHelper::generateResponse(false,'Faled to create admin');
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
        $validator = Validator::make($request->all(),['id' => 'required|exists:admins']);
        if(!$validator->fails()){
        $admin = Admin::find($id);
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $admin
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
            'id' => 'required|integer|exists:admins',
            'state_id'=>'required|integer|exists:states,id',
            'first_name' => 'required|string|min:3|max:10',
            'last_name' => 'required|string|min:3|max:10',
            'email' => 'required|email|unique:admins,email',
            'mobile' => 'required|numeric|unique:admins,mobile',
            'gender' => 'required|string|in:Male,Female',
            'image' => 'required|image',
            'status' => 'required|in:on',
        ];
        $validator = Validator($request->all(), $roles);
        if(!$validator->fails()){
           $admin = Admin::find($id);
           $admin->first_name = $request->get('first_name');
           $admin->last_name = $request->get('last_name');
           $admin->email = $request->get('email');
           $admin->mobile = $request->get('mobile');
           $admin->password = Hash::make('pass123$');
           $admin->state_id = $request->get('state_id');
           $admin->birth_date = $request->get('birth_date');
           $admin->gender = $request->get('gender');
           $admin->status = $request->has('status')?'Active':'InActive';

           if ($request->hasFile('image')) {
               $adminImage = $request->file('image');
               $name = time() . '_' . $request->get('first_name') . '.' . $adminImage->getClientOriginalExtension();
               $adminImage->move('images/admin', $name);
               $admin->image = $name;
           }
           $isUpdated = $admin->save();
           if($isUpdated){
            return ControllerHelper::generateResponse(true,'admin updated successfully');

           }else{
            return ControllerHelper::generateResponse(false,'Faled to update admin');
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
        $admin = Admin::findOrfail($id);
        $isDeleted = $admin->delete();
        if($isDeleted){
            return response()->json([
                'status'=>true,
                'message'=>'Deleted admin Successfully'
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'Failed to deleted admin!'
            ],400);
        }
    }
}
