@extends('hod.hod_layout')

@section('content')
<div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <h3 class="page-title">Manage User</h3>
        </div>
    </div>

    <div class="row" style="margin-left:250px">
        <div class="col-lg-8 col-md-12 col-sm-12 mb-4">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0">Add New User</h6>
                </div>
                <form method="POST" action="addUser" class="form-group" style="margin-top:20px" enctype="multipart/form-data">
                    @csrf
                    @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <p>{{\Session::get('success')}}
                        </div>
                    @endif
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">Full Name</label>
                        <div class="col-md-5">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span style="color:red" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="enrollment" class="col-md-4 col-form-label text-md-right">Enrollment</label>
                        <div class="col-md-5">
                            <input id="enrollment" type="text" class="form-control" name="enrollment" maxlength="12" value="{{ old('enrollment') }}">
                            @if ($errors->has('enrollment'))
                                <span style="color:red" role="alert">
                                    <strong>{{ $errors->first('enrollment') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                        <div class="col-md-5">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span style="color:red" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="branch" class="col-md-4 col-form-label text-md-right">Branch</label>
                        <div class="col-md-5">
                            <input id="branch" type="text" class="form-control" name="branch" value="{{ old('branch') }}">
                            @if ($errors->has('branch'))
                                <span style="color:red" role="alert">
                                    <strong>{{ $errors->first('branch') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="semester" class="col-md-4 col-form-label text-md-right">Semester</label>
                        <div class="col-md-5">
                            <input id="semester" type="number" class="form-control" name="semester" value="{{ old('semester') }}">
                            @if ($errors->has('semester'))
                                <span style="color:red" role="alert">
                                    <strong>{{ $errors->first('semester') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="mobileNo" class="col-md-4 col-form-label text-md-right">Mobile Number</label>
                        <div class="col-md-5">
                            <input id="mobileNo" type="text" class="form-control" name="mobileNo" maxlength="10" value="{{ old('mobileNo') }}">
                            @if ($errors->has('mobileNo'))
                                <span style="color:red" role="alert">
                                    <strong>{{ $errors->first('mobileNo') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="photo" class="col-md-4 col-form-label text-md-right">Photo</label>
                        <div class="col-md-5">
                            <input id="photo" type="file" class="form-control" name="photo" value="{{ old('photo') }}">
                            @if ($errors->has('photo'))
                                <span style="color:red" role="alert">
                                    <strong>{{ $errors->first('photo') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary" id="btn">
                                Add user
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
