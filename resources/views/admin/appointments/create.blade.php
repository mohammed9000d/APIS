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
                    <h4 class="card-title">Create Appointment</h4>
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

                <form action="{{route('appointments.store')}}"method="post">
                    @csrf
                        <div class="form-group">
                            <label>Date</label>
                            <input name="date" value="{{ old('date') }}" type="date" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Start Time</label>
                            <input name="start_time" value="{{ old('start_time') }}" type="time" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>End Time</label>
                            <input name="end_time" value="{{ old('end_time') }}" type="time" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Duration In Minutes</label>
                            <input name="duration_in_minutes" value="{{ old('duration_in_minutes') }}" type="number" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Details</label>
                            <input name = "details"value = "{{old('details')}}"type="text" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Price</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            <input name="price" value="{{ old('price') }}" type="text" class="form-control">
                        </div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Status</label>
                                <select name = "status" class="form-control">
                                    <option>-- Select --</option>
                                    <option value = "Pending" name = "Pending">Pending</option>
                                    <option value = "Accepted" name = "Accepted">Accepted</option>
                                    <option value = "InProcess" name = "InProcess">InProcess</option>
                                    <option value = "Finished" name = "Finished">Finished</option>
                                    <option value = "Canceled" name = "Canceled">Canceled</option>
                                    <option value = "Rejected" name = "Rejected">Rejected</option>
                                </select>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Doctors</label>
                                <select class="form-control" name = "doctor_id">
                                    <option>-- Select --</option>
                                    @foreach($doctors as $doctor)
                                    <option value = "{{ $doctor->id }}">{{ $doctor->first_name }}  {{ $doctor->last_name }}</option>
                                    @endforeach
                                </select>

                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Patients</label>
                                <select class="form-control" name = "patient_id">
                                    <option>-- Select --</option>
                                    @foreach($patients as $patient)
                                    <option value = "{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->last_name }}</option>
                                    @endforeach
                                </select>
                        </div>

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
