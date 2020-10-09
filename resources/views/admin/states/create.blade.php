@extends('admin.parent')

@section('title','Dashboard')

@section('style')
    <link rel="stylesheet" href="{{asset('doccure/admin/assets/css/select2.min.css')}}">
    <style>
        .error{
            color:red;
        }
    </style>
@endsection

@section('page-wrapper')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create State</h4>
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
                        {{session()->get('messege')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                <form action="{{route('states.store')}}"method="post" id = "create_state_form">
                    @csrf
                    <div class="form-group">
                        <label class="col-form-label">City</label>

                            <select class="form-control" name="city_id">
                                <option>-- Select --</option>
                                @foreach($cities as $city)
                                <option value="{{$city->id}}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input name = "name"value = "{{old('name')}}"type="text" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Activity status</label>
                            <div class="status-toggle">
                                <input name= "status" type="checkbox" id="status_1" class="check" checked>
                                <label for="status_1" class="checktoggle">checkbox</label>
                            </div>
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

    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script>
    $("#create_state_form").validate({
        rules: {
          name: {
            required: true,
            minlength:3 ,
            maxlength:10,
          }
        },
        messages:{
            name:{
                required:'please, enter state name',
            }
        }
      });
    </script>
@endsection
