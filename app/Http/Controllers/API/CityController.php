<?php

namespace App\Http\Controllers\API;
use App\City;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource bw z NBVWGSDFGH0-Q.*
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cities = City::all();
        return response()->json([
            'status'=>true,
            'message'=>'Success',
            'cities'=>$cities
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
            'name'=>'required|string|min:3|max:15'
        ];
        $validator = Validator($request->all(), $roles);
        if(!$validator->fails()){
           $city = new City ();
           $city->name = $request->get('name');
           $isSaved = $city->save();
           if($isSaved){
            return response()->json([
                'status'=>true,
                'message'=>'city Created successfully'
            ]);
           }else{
            return response()->json([
                'status'=>false,
                'message'=>'Faled to create city'
            ]);
           }
        }else{
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()

            ]);
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
        $validator = Validator::make($request->all(),['id' => 'required|exists:cities']);
        if(!$validator->fails()){
        $city = City::find($id);
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $city
        ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ]);
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
            'id' => 'required|integer|exists:cities',
            'name'=>'required|string|min:3|max:15'
        ];
        $validator = Validator($request->all(), $roles);
        if(!$validator->fails()){
           $city = City::find($id);
           $city->name = $request->get('name');
           $isSaved = $city->save();
           if($isSaved){
            return response()->json([
                'status'=>true,
                'message'=>'City updated successfully'
            ]);
           }else{
            return response()->json([
                'status'=>false,
                'message'=>'Faled to update city'
            ]);
           }
        }else{
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()

            ]);
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
        $city = City::findOrfail($id);
        $isDeleted = $city->delete();
        if($isDeleted){
            return response()->json([
                'status'=>true,
                'message'=>'Deleted City Successfully'
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'Failed to deleted city!'
            ],400);
        }
    }
}
