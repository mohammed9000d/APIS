<?php

namespace App\Http\Controllers;
use App\Invoice;
use App\Patient;
use App\Appointment;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $inovices = Invoice::all();
        return view('admin.invoices.index',['invoices'=>$inovices]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $appointments = Appointment::all();
        return view('admin.invoices.create',['appointments'=>$appointments ]);
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
            'appointment_id'=>'required|exists:appointments,id',
            // 'patient_id'=>'required|integer|exists:patients,id',
            'price'=>'required|numeric',
            'status'=>'required|in:Paid,Pending',
            'paid_date'=>'required|string|max:100',
            'payment_type'=>'required|in:Cash,Visa',
            'discount'=>'required|numeric',
        ]);
        $invoice = new Invoice();
        $invoice->appointment_id = $request->get('appointment_id');
        // $invoice->patient_id = $request->get('patient_id');
        $invoice->price = $request->get('price');
        $invoice->status = $request->get('status');
        $invoice->paid_date = $request->get('paid_date');
        $invoice->payment_type = $request->get('payment_type');
        $invoice->price = $request->get('price');
        $invoice->discount = $request->get('discount');

        $isSaved = $invoice->save();
        if($isSaved){
            session()->flash('alert-type','alert-success');
            session()->flash('message','Invoice created successfully');
            return redirect()->back();
        }else{
            session()->flash('alert-type','alert-danger');
            session()->flash('message','Failed to create invoice');
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
        $appointments = Appointment::all();
        $invoice = Invoice::findOrfail($id);
        return view('admin.invoices.edit',['appointments'=>$appointments ],['invoice'=>$invoice ]);
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
            'id'=>'required|exists:invoices,id',
            'appointment_id'=>'required|exists:appointments,id',
            'price'=>'required|numeric',
            'status'=>'required|in:Paid,Pending',
            'paid_date'=>'required|string|max:100',
            'payment_type'=>'required|in:Cash,Visa',
            'discount'=>'required|numeric',
        ]);
        $invoice = Invoice::find($id);
        $invoice->appointment_id = $request->get('appointment_id');
        $invoice->price = $request->get('price');
        $invoice->status = $request->get('status');
        $invoice->paid_date = $request->get('paid_date');
        $invoice->payment_type = $request->get('payment_type');
        $invoice->price = $request->get('price');
        $invoice->discount = $request->get('discount');

        $isUpdate = $invoice->save();
        if($isUpdate){
            session()->flash('alert-type','alert-success');
            session()->flash('message','Invoice updated successfully');
            return redirect()->back();
        }else{
            session()->flash('alert-type','alert-danger');
            session()->flash('message','Failed to update invoice');
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
