@extends('admin.parent')

@section('title','Dashboard')

@section('style')
    <link rel="stylesheet" href="{{asset('doccure/admin/assets/css/select2.min.css')}}">
@endsection

@section('page-wrapper')
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create Specialty</h4>
                </div>
                @if($errors->any())
                @foreach($errors->all() as $error)

                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                     {{ $error }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                @endforeach

                @endif

                @if(session()->has('alert-type'))
                <div class="alert {{session()->get('alert-type') }} alert-dismissible fade show" role="alert">
                    {{session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                @endif
                        <div class="card-body">
                            <form action="{{ route('specialties.store') }}" method = "POST"
                            enctype = "multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Title en</label>
                                    <input name = "title_en" value = "{{ old('title_en') }}" type="text" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Description en</label>
                                    <input name = "description_en" value = "{{ old('description_en') }}" type="text" class="form-control">
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">Image</label>
                                    <div class="col-md-10">
                                        <input class="form-control" name="image" type="file" accept="image/*">
                                        {{-- <input type="file" class="custom-file-input" name="author_image"> --}}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Activity Status</label>
                                    <div class="status-toggle">
                                        <input  name = "status" type="checkbox" id="status_1" class="check" checked="">
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
@endsection
