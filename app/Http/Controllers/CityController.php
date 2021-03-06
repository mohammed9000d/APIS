<?php

namespace App\Http\Controllers;

use App\City;
use App\State;
use Illuminate\Http\Request;


class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::withcount('states')->get();
        return view ('admin.cities.index',['cities'=>$cities]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cities.create');
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
            'name' => 'required|string|min:3|max:15|unique:cities,name',
            'status'=> 'required'
        ],[
            'name.required'=>'please, enter city name',
            'name.min'=>'Name must be at least 3 characters lenght',

            ]);
        $city = new City();
        $city->name = $request->get('name');
        $city->status = $request->has('status') ? 'Active':'InActive';
        $issaved = $city->save();
        // $city = City::create($validator->validated());

        if($issaved){
            session()->flash('alert-type','alert-success');
            session()->flash('messege','City created successfully');
            return redirect()->back();
        }else
        session()->flash('alert-type','alert-danger');
        session()->flash('messege','Failed to create city');
        return redirect()->back();
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
        $city = City::findOrFail($id);
         return view('admin.cities.edit',['city'=>$city]);
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
            'id'=> 'required|integer|exists:cities|unique:cities,name,'.$id,
            'name'=> 'required|string|min:3|max:15',
            'status'=> 'in:on'
        ]);
        // $city = City::find($id)->updated($validator->validated());
        $city = City::find($id);
        $city->name = $request->get('name');
        $city->status = $request->has('status') ? 'Active' : 'InActive';
        $isupdated = $city->save();
        if($isupdated){
            session()->flash('alert-type','alert-success');
            session()->flash('messege','City add successfully');
            return redirect()->back();
        }else
            session()->flash('alert-type','alert-danger');
            session()->flash('messege','Failed to create city');
            return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isDeleted = City::destroy($id);
        if($isDeleted){
            return response()->json([
                'title'=>'Success',
                'text'=>'City Deleted Successfully',
                'icon'=>'success'
            ],200);
        }else{
            return response()->json([
                'title'=>'Faild',
                'text'=>'Failde To Delete City!',
                'icon'=>'error'
            ],400);

        }
    }
    public function showStates($id){
        // $states = State::paginate(5);
        $states = City::find($id)->states;
        return view('admin.states.index',['states'=>$states]);
    }
}
