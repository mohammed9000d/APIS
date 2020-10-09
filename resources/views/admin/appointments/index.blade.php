@extends('admin.parent')

@section('title','Appointments')

@section('style')

@endsection

@section('page-title','Appointments')
@section('page-breadcrumb','Appointments')

@section('action')
    <div class="col-sm-5 col">
        <a href="{{ route('appointments.create') }}" class="btn btn-primary float-right mt-2">Add</a>
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
                                <th>Doctor Name</th>
                                <th>Patient Name</th>
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Duration In Minutes</th>
                                <th>Status</th>
                                <th>Details</th>
                                <th>Price</th>
                                <th>Created At</th>
                                <th>Setting</th>

                            </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->id}}</td>
                                    <td>{{$appointment->doctor->first_name }}  {{ $appointment->doctor->last_name }}</td>
                                    <td>{{$appointment->patient->first_name }}  {{ $appointment->patient->last_name }}</td>
                                    <td>{{ $appointment->date}}</td>
                                    <td>{{ $appointment->start_time}}</td>
                                    <td>{{ $appointment->end_time}}</td>
                                    <td>{{ $appointment->duration_in_minutes}}</td>
                                    <td>{{ $appointment->status }}</td>
                                    <td>{{ $appointment->details }}</td>
                                    <td>${{ $appointment->price }}</td>
                                    <td>{{ $appointment->created_at }}</td>
                                    <td>
                                        <a href = "{{route('appointments.edit',[$appointment->id])}}"type="button" class="btn btn-primary active">Edit</a>
                                        <a href = "#" onclick = "confirmDelete(this,'{{ $appointment->id }}')" type="button" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{--  <dive class = "row justify-content-center">
                    {{ $appointments->links() }}
                </dive>  --}}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('doccure/js/axios.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function confirmDelete(app,id){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
             deleteSpecialty(app,id)
            }
          })
    }
    function deleteSpecialty(app,id){
        axios.delete('/cms/admin/appointments/'+id)
        .then(function (response) {
        // handle success
        console.log(response);
        app.closest('tr').remove();
        showDeleted(response.data);
        })
        .catch(function (error) {
        // handle error
        console.log(error);
        })
        .then(function () {
        // always executed
        });
}
    function showDeleted(data){
        Swal.fire({
            title: data.title,
            text: data.text,
            icon: data.icon,
            showConfirmButton:false,
            timer: 2000,
          }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
              console.log('I was closed by the timer')
            }
          })
    }
</script>

@endsection
