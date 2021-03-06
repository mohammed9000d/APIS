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
                    <h4 class="card-title">Create Doctor</h4>
                </div>
                <div class="card-body">

                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $error }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endforeach
                    @endif

                    @if (session()->has('alert-type'))
                        <div class="alert {{ session()->get('alert-type') }} alert-dismissible fade show" role="alert">
                            {{ session()->get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('doctors.store') }}" method="POST"
                    enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="col-form-label">City</label>
                            <select class="form-control" id="city_id" name="city_id" onchange="getCityStates()">
                                <option>-- Select --</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">State</label>
                            <select class="form-control" id="state_id" name="state_id">
                                <option>-- Select --</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Specialty</label>
                                <select class="form-control" name="specialty_id">
                                    <option>-- Select --</option>
                                    @foreach($specialties as $specialty)
                                    <option value="{{$specialty->id }}">{{ $specialty->title_en }}</option>
                                    @endforeach
                                </select>
                            </div>

                        <div class="form-group">
                            <label>First Name</label>
                            <input name="first_name" value="{{ old('first_name') }}" type="text" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Last Name</label>
                            <input name="last_name" value="{{ old('last_name') }}" type="text" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input name="email" value="{{ old('email') }}" type="email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Mobile</label>
                            <input name="mobile" value="{{ old('mobile') }}" type="tel" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Birth Date</label>
                            <input name="birth_date" value="{{ old('birth_date') }}" type="date" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="d-block">Gender:</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="gender_male" value="Male">
                                <label class="form-check-label" for="gender_male">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="gender_female" value="Female">
                                <label class="form-check-label" for="gender_female">Female</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Image</label>
                            <div class="col-md-10">
                                <input class="form-control" name="image" type="file" accept="image/*">
                                {{-- <input type="file" class="custom-file-input" name="author_image"> --}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Pricing</label>
                                <select name = "pricing" class="select">
                                    <option>-- Select --</option>
                                    <option value="Free">Free</option>
                                    <option value="PerHour">PerHour</option>
                                </select>
                        </div>

                        <div class="form-group">
                            <label>Hour Price</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            <input name="hour_price" value="{{ old('hour_price') }}" type="text" class="form-control">
                        </div>
                        </div>

                        <div class="form-group">
                            <label>Facebook Url</label>
                            <input name="facebook_url" value="{{ old('facebook_url') }}" type="text" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Twitter Url</label>
                            <input name="twitter_url" value="{{ old('twitter_url') }}" type="text" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Linked_in Url</label>
                            <input name="linked_in_url" value="{{ old('linked_in_url') }}" type="text" class="form-control">
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">About</label>
                            <div class="col-lg-9">
                                <textarea rows="4" name="about" value="{{ old('about') }}" cols="5" class="form-control" placeholder="Enter message"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Activity Status</label>
                            <div class="status-toggle">
                                <input name="status" type="checkbox" id="status_1" class="check" checked>
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
    </div>
@endsection

@section('scripts')
    <script src="{{asset('doccure/admin/assets/js/select2.min.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

    <script>

        function getCityStates(){
            var selectedCityId = document.getElementById('city_id').value;

            var stateSelect = document.getElementById('state_id');
            stateSelect.length = 0;

            @foreach($cities as $city)
            if(selectedCityId == '{{ $city->id }}'){
                @foreach($city->states as $state)
                    var option = document.createElement('option');
                    option.text = '{{ $state->name }}';
                    option.value = '{{ $state->id }}'
                    stateSelect.add(option);
                @endforeach
            }
            @endforeach
        }
    </script>
@endsection
