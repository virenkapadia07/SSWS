@extends('gatekeeper.layout')

@section('content')
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Home</span>
        <h3 class="page-title">Student Verification</h3>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div><br/>
        @endif
        <div class="card card-small">
            <div class="card-header border-bottom">
                <h6 class="m-0">Check Students</h6>
            </div>
            <form method="POST" action="checkStudent" class="form-group" style="margin-top:20px" enctype="multipart/form-data">
                @csrf
                @if (\Session::has('wrong'))
                    <div class="alert alert-danger">
                        <p>{{\Session::get('wrong')}}
                    </div>
                @endif
                <div class="form-group row">
                    <label for="enrollment" class="col-md-4 col-form-label text-md-right">Enter Enrollment</label>
                    <div class="col-md-5">
                        <input id="enrollment" type="text" class="form-control" name="enrollment" value="{{ old('enrollment') }}" maxlength="12">
                        @if ($errors->has('enrollment'))
                            <span style="color:red" role="alert">
                                <strong>{{ $errors->first('enrollment') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <input type="hidden" name="todate" id="todate">
                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary" id="btn">
                            Check Student
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

window.onload=function() {
    var today = new Date();
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    document.getElementById('todate').value=date;
}
</script>

@endsection
