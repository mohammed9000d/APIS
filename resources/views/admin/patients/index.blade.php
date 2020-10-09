@extends('admin.parent')

@section('title','Patients')

@section('style')

@endsection

@section('page-title','Patients')
@section('page-breadcrumb','Patients')

@section('action')
    <div class="col-sm-5 col">
    <a href="{{route('patients.create')}}"  class="btn btn-primary float-right mt-2">Add</a>
    </div>
@endsection

@section('page-wrapper')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>ID</th>
                                <th>First Name </th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Mobiel</th>
                                <th>Birth date</th>
                                <th>Gender</th>
                                <th>Status</th>
                                <th>Blode type</th>
                                <th>Created At</th>
                                <th>Setting</th>
                            </tr>
                                </thead>
                                <tbody>

                                @foreach($patients as $patient)

                                <tr>
                                    <td>
                                        <div class="avatar avatar-lg">
                                            <img class="avatar-img rounded-circle" alt="User Image" src="{{url('images/patient/'.$patient->image) }}">
                                        </div>
                                    </td>
                                    <td>{{ $patient->id }}</td>
                                    <td>{{ $patient->first_name }}</td>
                                    <td>{{ $patient->last_name }}</td>
                                    <td>{{ $patient->email }}</td>
                                    <td>{{ $patient->mobile }}</td>
                                    <td>{{ $patient->birth_date}}</td>
                                    <td>{{ $patient->gender }}</td>
                                    <td>{{ $patient->status}}</td>
                                    <td>{{ $patient->blood_type }}</td>
                                    <td>{{ $patient->created_at }}</td>
                                    <td>
                                        <a href = "{{route('patients.edit',[$patient->id])}}"type="button" class="btn btn-primary active">Edit</a>
                                        <a href = "#" onclick = "confirmDelete(this,'{{ $patient->id }}')" type="button" class="btn btn-danger">Delete</a>

                                    </td>
                                </tr>


                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
                {{--  <dive class = "row justify-content-center">
                    {{ $patients->links() }}
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
        axios.delete('/cms/admin/patients/'+id)
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
