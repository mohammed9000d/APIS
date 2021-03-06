<?php

namespace App\Http\Controllers\API;
use App\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource bw z NBVWGSDFGH0-Q.*
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $invoices = Invoice::all();
        return response()->json([
            'status'=>true,
            'message'=>'Success',
            'invoices'=>$invoices
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

        $roles = [
            'appointment_id'=>'required|exists:appointments,id',
            'price'=>'required|numeric',
            'status'=>'required|in:Paid,Pending',
            'paid_date'=>'required|string|max:100',
            'payment_type'=>'required|in:Cash,Visa',
            'discount'=>'required|numeric',
        ];
        $validator = Validator($request->all(), $roles);
        if(!$validator->fails()){
            $invoice = new Invoice();
            $invoice->appointment_id = $request->get('appointment_id');
            $invoice->price = $request->get('price');
            $invoice->status = $request->get('status');
            $invoice->paid_date = $request->get('paid_date');
            $invoice->payment_type = $request->get('payment_type');
            $invoice->price = $request->get('price');
            $invoice->discount = $request->get('discount');
            $isSaved = $invoice->save();
            if($isSaved){
                return ControllerHelper::generateResponse(true,'invoice Created successfully');

            }else{
                return ControllerHelper::generateResponse(false,'Faled to create invoice');
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
        $validator = Validator::make($request->all(),['id' => 'required|exists:invoices']);
        if(!$validator->fails()){
        $invoice = Invoice::find($id);
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $invoice
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
            'appointment_id'=>'required|exists:appointments,id',
            'price'=>'required|numeric',
            'status'=>'required|in:Paid,Pending',
            'paid_date'=>'required|string|max:100',
            'payment_type'=>'required|in:Cash,Visa',
            'discount'=>'required|numeric',
        ];
        $validator = Validator($request->all(), $roles);
        if(!$validator->fails()){
           $invoice = Invoice::find($id);
           $invoice->appointment_id = $request->get('appointment_id');
           $invoice->price = $request->get('price');
           $invoice->status = $request->get('status');
           $invoice->paid_date = $request->get('paid_date');
           $invoice->payment_type = $request->get('payment_type');
           $invoice->price = $request->get('price');
           $invoice->discount = $request->get('discount');
           $isUpdated = $invoice->save();
           if($isUpdated){
            return ControllerHelper::generateResponse(true,'invoice updated successfully');

           }else{
            return ControllerHelper::generateResponse(false,'Faled to update invoice');
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
        $invoice = Invoice::findOrfail($id);
        $isDeleted = $invoice->delete();
        if($isDeleted){
            return response()->json([
                'status'=>true,
                'message'=>'Deleted invoice Successfully'
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'Failed to deleted invoice!'
            ],400);
        }
    }
}
