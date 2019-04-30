@extends('user.layout')

@section('content')
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h3 class="page-title">Settings</h3>
    </div>
</div>

<div class="row" style="margin-left:260px">
    <div class="col-lg-8 col-md-12 col-sm-12 mb-4">
        @if (\Session::has('wrong'))
        <div class="alert alert-danger">
            <p>{{\Session::get('wrong')}}
        </div>
        @endif
        <div class="card card-small">
            <div class="card-header border-bottom">
                <h6 class="m-0">Change Password</h6>
            </div>

            <div class="card-body">

                <form method="POST" action="changePassword">
                    @csrf

                    <div class="form-group row">
                        <label for="date" class="col-md-5 col-form-label text-md-right">Current Password</label>
                        <div class="col-md-6">
                            <input type="password" name="password" id="password" class="form-control" onkeyup="checkPwd()">
                                <span style="color:red" role="alert" id="errorPassword"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="date" class="col-md-5 col-form-label text-md-right">Enter New Password</label>
                        <div class="col-md-6">
                            <input type="password" name="newpassword" id="newpassword" class="form-control" onkeyup="checkNew()">
                                <span style="color:red" role="alert" id="errorNew">
                                </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="date" class="col-md-5 col-form-label text-md-right">Re-Enter New Password</label>
                        <div class="col-md-6">
                            <input type="password" name="renewpassword" id="renewpassword" class="form-control" onkeyup="checkRe()">
                                <span style="color:red" role="alert" id="errorRe"></span>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary" id='btn'>
                                Change Password
                            </button>
                        </div>
                    </div>

                </form>

        </div>
    </div>
</div>

<script>
    window.onload=function() {
        document.getElementById("btn").disabled = true;
    }

    function checkPwd()
    {
        var NewPwd=document.getElementById('password').value;

        if(NewPwd=='')
        {
            document.getElementById('errorPassword').innerHTML="Filed should not be empty";
            document.getElementById("btn").disabled = true;
        }
        else
        {
            document.getElementById('errorPassword').innerHTML="";
            document.getElementById("btn").disabled = false;
        }
        checkNew();
    }

    function checkNew()
    {
        var NewPwd=document.getElementById('newpassword').value;
        var reg=/^(?=.*\d).{6,32}/

        if(NewPwd=='')
        {
            document.getElementById('errorNew').innerHTML="Filed should not be empty";
            document.getElementById("btn").disabled = true;
        }
        else if(!reg.test(NewPwd))
		{
            document.getElementById('errorNew').innerHTML="Password should be atleast 6 characters and atleast one digit";
            document.getElementById("btn").disabled = true;
        }
        else
        {
            document.getElementById('errorNew').innerHTML="";
            document.getElementById("btn").disabled = false;
        }
        checkPwd();
    }

    function checkRe()
    {
        var NewPwd=document.getElementById('renewpassword').value;
        var pwd=document.getElementById('newpassword').value;

        if(NewPwd=='')
        {
            document.getElementById('errorRe').innerHTML="Filed should not be empty";
            document.getElementById("btn").disabled = true;
        }
        else if(NewPwd!=pwd)
        {
            document.getElementById('errorRe').innerHTML="Password does not match the new Password";
            document.getElementById("btn").disabled = true;
        }
        else{
            document.getElementById('errorRe').innerHTML="";
            document.getElementById("btn").disabled = false;
        }
        checkPwd();
    }
</script>
@endsection
