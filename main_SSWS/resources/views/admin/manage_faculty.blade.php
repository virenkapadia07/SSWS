@extends('admin.admin_layout')

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
                    <h6 class="m-0">Add New Faculty</h6>
                </div>
                <form method="POST" action="addFaculty" class="form-group" style="margin-top:20px" enctype="multipart/form-data">
                    @csrf
                    @if (\Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">x</span>
                            </button>
                            {{-- <i class="fa fa-info mx-2"></i> --}}
                            <strong>{{\Session::get('success')}}</strong>
                        </div>
                    @endif
                    <div class="form-group row">
                        <label for="fname" class="col-md-4 col-form-label text-md-right">First Name</label>
                        <div class="col-md-5">
                            <input id="fname" type="text" class="form-control" name="fname" value="{{ old('fname') }}" required>
                            @if ($errors->has('name'))
                                <span style="color:red" role="alert">
                                    <strong>{{ $errors->first('fname') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="mname" class="col-md-4 col-form-label text-md-right">Middle Name</label>
                        <div class="col-md-5">
                            <input id="mname" type="text" class="form-control" name="mname" value="{{ old('mname') }}" required>
                            @if ($errors->has('mname'))
                                <span style="color:red" role="alert">
                                    <strong>{{ $errors->first('mname') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-md-4 col-form-label text-md-right">Last Name</label>
                        <div class="col-md-5">
                            <input id="namle" type="text" class="form-control" name="lname" value="{{ old('lname') }}" required>
                            @if ($errors->has('lname'))
                                <span style="color:red" role="alert">
                                    <strong>{{ $errors->first('lname') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                        <div class="col-md-5">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span style="color:red" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="deparment" class="col-md-4 col-form-label text-md-right">Department</label>
                        <div class="col-md-5">
                            <select name="department" id="department" class="form-control">
                                <option value="Information Technology">Information Technology</option>
                                <option value="Computer Science">Computer Science</option>
                                <option value="Mechanical">Mechanical</option>
                                <option value="Civil">Civil</option>
                                <option value="Automobile">Automobile</option>
                                <option value="Electrical">Electrical</option>
                            </select>
                            @if ($errors->has('deparment'))
                                <span style="color:red" role="alert">
                                    <strong>{{ $errors->first('deparment') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="mobileNo" class="col-md-4 col-form-label text-md-right">Mobile Number</label>
                        <div class="col-md-5">
                            <input id="mobileNo" type="text" class="form-control" name="mobileNo" maxlength="10" value="{{ old('mobileNo') }}" required>
                            @if ($errors->has('mobileNo'))
                                <span style="color:red" role="alert">
                                    <strong>{{ $errors->first('mobileNo') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary" id="btn">
                                Add Faculty
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
