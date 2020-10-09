@extends('admin.parent')

@section('title','Cities')

@section('style')

@endsection

@section('page-title','Cities')
@section('page-breadcrumb','Cities')

@section('action')
    <div class="col-sm-5 col">
        <a href="{{ route('cities.create') }}" class="btn btn-primary float-right mt-2">Add</a>
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
                                <th>Name</th>
                                <th>State Count</th>
                                <th>status</th>
                                <th>Created At</th>
                                <th>Setting</th>

                            </tr>
                            </thead>
                            <tbody>
                                @foreach($cities as $city)
                                <tr>
                                    <td>{{ $city->id}}</td>
                                    <td>{{ $city->name}}</td>
                                    <td>
                                        <a href = "{{ route('cities.states',[$city->id]) }}"type="button" class="btn btn-primary active">State/s- {{ $city->states_count}}</a>
                                    </td>
                                    <td>{{ $city->status }}</td>
                                    <td>{{ $city->created_at }}</td>
                                    <td>
                                        <a href = "{{route('cities.edit',[$city->id])}}"type="button" class="btn btn-primary active">Edit</a>
                                        <a href = "#" onclick = "confirmDelete(this,'{{ $city->id }}')" type="button" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{--  <dive class = "row justify-content-center">
                    {{ $cities->links() }}
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
        axios.delete('/cms/admin/cities/'+id)
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
