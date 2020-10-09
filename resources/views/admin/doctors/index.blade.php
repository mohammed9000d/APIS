@extends('admin.parent')

@section('title','Doctors')

@section('style')

@endsection

@section('page-title','Doctors')
@section('page-breadcrumb','Doctors')

@section('action')
    <div class="col-sm-5 col">
    <a href="{{route('doctors.create')}}"  class="btn btn-primary float-right mt-2">Add</a>
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
                                <th>Specialty</th>
                                <th>Email</th>
                                <th>Mobiel</th>
                                <th>Gender</th>
                                <th>Birth date</th>
                                {{-- <th>About</th> --}}
                                <th>Status</th>
                                <th>States</th>
                                <th>Pricing</th>
                                <th>Hour price</th>
                                <th>Facebook url</th>
                                <th>Twitter url</th>
                                <th>Linked_in url</th>
                                <th>Created At</th>
                                <th>Setting</th>
                            </tr>
                                </thead>
                                <tbody>

                                @foreach($doctors as $doctor)

                                <tr>
                                    <td>
                                        <div class="avatar avatar-lg">
                                            <img class="avatar-img rounded-circle" alt="User Image" src="{{url('images/doctor/'.$doctor->image) }}">
                                        </div>
                                    </td>
                                    <td>{{ $doctor->id }}</td>
                                    <td>{{ $doctor->first_name }}</td>
                                    <td>{{ $doctor->last_name }}</td>
                                    <td>{{ $doctor->specialty->title_en }}</td>
                                    <td>{{ $doctor->email }}</td>
                                    <td>{{ $doctor->mobile }}</td>
                                    <td>{{ $doctor->gender }}</td>
                                    <td>{{ $doctor->birth_date}}</td>
                                    {{-- <td>{{ $doctor->about }}</td> --}}
                                    <td>{{ $doctor->status}}</td>
                                    <td>{{ $doctor->state->name}}</td>
                                    <td>{{ $doctor->pricing }}</td>
                                    <td>{{ $doctor->hour_price }}</td>
                                    <td>{{ $doctor->facebook_url }}</td>
                                    <td>{{ $doctor->twitter_url }}</td>
                                    <td>{{ $doctor->linked_in_url }}</td>
                                    <td>{{ $doctor->created_at }}</td>
                                    <td>
                                        <a href = "{{route('doctors.edit',[$doctor->id])}}"type="button" class="btn btn-primary active">Edit</a>
                                        <a href = "#" onclick = "confirmDelete(this,'{{ $doctor->id }}')" type="button" class="btn btn-danger">Delete</a>

                                    </td>
                                </tr>


                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
                {{--  <dive class = "row justify-content-center">
                    {{ $doctors->links() }}
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
        axios.delete('/cms/admin/doctors/'+id)
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
