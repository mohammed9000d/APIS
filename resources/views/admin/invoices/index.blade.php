@extends('admin.parent')

@section('title','Invoices')

@section('style')

@endsection

@section('page-title','Invoices')
@section('page-breadcrumb','Invoices')

@section('action')
    <div class="col-sm-5 col">
    <a href="{{route('invoices.create')}}"  class="btn btn-primary float-right mt-2">Add</a>
    </div>
@endsection

@section('page-wrapper')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="datatable table table-hover table-center mb-0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Appointment Id</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Paid Date</th>
                                <th>Payment Type</th>
                                <th>Discount</th>
                                <th>Created At</th>
                                <th>Setting</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $invoice)


                            <tr>
                                <td>{{$invoice->id}}</td>
                                <td>{{$invoice->appointment_id}}</td>
                                <td>${{$invoice->price}}</td>
                                <td>{{$invoice->status}}</td>
                                <td>{{$invoice->paid_date}}</td>
                                <td>{{$invoice->payment_type}}</td>
                                <td>${{$invoice->discount}}</td>
                                <td>{{$invoice->created_at}}</td>
                                <td>
                                    <a href = "{{route('invoices.edit',[$invoice->id])}}"type="button" class="btn btn-primary active">Edit</a>
                                </td>
                            </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{--  <dive class = "row justify-content-center">
                    {{ $invoices->links() }}
                </dive>  --}}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{--  <!-- Datatables JS -->
    <script src="{{asset('doccure/admin/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('doccure/admin/assets/plugins/datatables/datatables.min.js')}}"></script>  --}}
@endsection
