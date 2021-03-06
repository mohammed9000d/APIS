<?php

namespace App\Http\Controllers\API;
use App\State;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StateController extends Controller
{
    /**
     * Display a listing of the resource bw z NBVWGSDFGH0-Q.*
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $states = State::all();
        return response()->json([
            'status'=>true,
            'message'=>'Success',
            'states'=>$states
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
            'city_id'=>'required|integer|exists:cities,id',
            'name'=>'required|string|min:3|max:15',
            'status'=>'required',
        ];
        $validator = Validator($request->all(), $roles);
        if(!$validator->fails()){
           $state = new State ();
           $state->city_id = $request->get('city_id');
           $state->name = $request->get('name');
           $state->status = $request->has('status') ?'Active' : 'InActive';
           $isSaved = $state->save();
           if($isSaved){
           return ControllerHelper::generateResponse(true,'state Created successfully');
           }else{
            return ControllerHelper::generateResponse(false,'Faled to create state');
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
        $validator = Validator::make($request->all(),['id' => 'required|exists:states']);
        if(!$validator->fails()){
        $state = State::find($id);
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $state
        ]);
        }else{
            return  ControllerHelper::generateResponse(false,$validator->getMessageBag()->first());
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
            'id' => 'required|integer|exists:states',
            'city_id'=>'required|integer|exists:cities,id',
            'name'=>'required|string|min:3|max:15',
            'status'=>'required',
        ];
        $validator = Validator($request->all(), $roles);
        if(!$validator->fails()){
           $state = State::find($id);
           $state->city_id = $request->get('city_id');
           $state->name = $request->get('name');
           $state->status = $request->has('status') ?'Active' : 'InActive';
           $isUpdated = $state->save();
            if($isUpdated){
                return ControllerHelper::generateResponse(true,'state Created successfully');

               }else{
                return ControllerHelper::generateResponse(false,'Faled to create state');
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
        $state = State::findOrfail($id);
        $isDeleted = $state->delete();
        if($isDeleted){
            return response()->json([
                'status'=>true,
                'message'=>'Deleted State Successfully'
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'Failed to deleted state!'
            ],400);
        }
    }
}
