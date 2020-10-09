@extends('admin.parent')

@section('title','Dashboard')

@section('style')
    <link rel="stylesheet" href="{{asset('doccure/admin/assets/css/select2.min.css')}}">
@endsection

@section('page-wrapper')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create Invoice</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{$error}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    @endforeach

                    @endif
                    @if (session()->has('alert-type'))
                    <div class="alert {{session()->get('alert-type')}} alert-dismissible fade show" role="alert">
                        {{session()->get('message')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                <form action="{{route('invoices.store')}}"method="post">
                    @csrf

                        {{--  <div class="form-group">
                            <label class="col-form-label">Patient Name</label>
                                <select class="form-control" name = "patient_id">
                                    <option>-- Select --</option>
                                    @foreach($patients as $patient)
                                    <option value = "{{ $patient->id }}">{{$patient->first_name}} {{$patient->last_name}}</option>
                                    @endforeach
                                </select>
                        </div>  --}}

                        <div class="form-group">
                            <label class="col-form-label">Appointment Id</label>
                                <select class="form-control" name = "appointment_id">
                                    <option>-- Select --</option>
                                    @foreach($appointments as $appointment)
                                    <option value = "{{ $appointment->id }}">{{$appointment->id}}</option>
                                    @endforeach
                                </select>
                        </div>

                        <div class="form-group">
                            <label>Price</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            <input name="price" value="{{ old('price') }}" type="text" class="form-control">
                        </div>
                        </div>

                        <div class="form-group">
                            <label>Paid Date</label>
                            <input name = "paid_date"value = "{{old('paid_date')}}"type="date" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Status</label>
                                <select name = "status" class="form-control">
                                    <option>-- Select --</option>
                                    <option value = "Pending" name = "Pending">Pending</option>
                                    <option value = "Paid" name = "Paid">Accepted</option>
                                </select>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Payment Type</label>
                                <select name = "payment_type" class="form-control">
                                    <option>-- Select --</option>
                                    <option value = "Cash" name = "Cash">Cach</option>
                                    <option value = "Visa" name = "Visa">Visa</option>
                                </select>
                        </div>
                        <div class="form-group">
                            <label>Discount</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>

                            <input name="discount" value="{{ old('discount') }}" type="text" class="form-control">
                        </div>
                    </div>

                        {{--  <div class="form-group">
                            <label class="col-form-label col-lg-2">Discount</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
														<span class="input-group-text">
															<input type="checkbox">
														</span>
                                    </div>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input name="discount" value="{{ old('discount') }}"  type="text" class="form-control">
                                </div>
                            </div>  --}}


                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

@endsection

@section('scripts')
    <script src="{{asset('doccure/admin/assets/js/select2.min.js')}}"></script>
@endsection
