@if (Session::has('logged_in'))
    <script>
        window.location="home";
    </script>
@endif

<!DOCTYPE HTML>
<html>

<head>
	<title>Registration</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
	<link href="login/css/font-awesome.css" rel="stylesheet">
    <link href="login/css/style.css" rel='stylesheet' type='text/css' />
</head>

<body>
	<h1>Registration</h1>
	    <div class="w3ls-login box box--big">
    		<form action="submitted" method="post">
                @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <p>{{\Session::get('success')}}</p>
                    </div>
                @endif
                @csrf
			    <div class="agile-field-txt">
    				<label><i class="fa fa-user" aria-hidden="true"></i> Enrollment No. </label>
                    <input type="text" name="enrollment" id="enrollment" placeholder="Enter Enrollment No." class="form-control{{ $errors->has('enrollment') ? ' is-invalid' : '' }}" maxlength="12" value="{{ old('enrollment') }}" />
                    @if ($errors->has('enrollment'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('enrollment') }}</strong>
                        </span>
                    @endif
			    </div>
			    <div class="agile-field-txt">
    				<label><i class="fa fa-at" aria-hidden="true"></i> Email Address </label>
                    <input type="text" name="email" placeholder="Enter Email Address" id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" maxlength="32" value="{{ old('email') }}" />
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
				    <div class="agile-left">
    					<a href="/">Already Registered? Sign In!!</a>
				    </div>
                </div>
                <input type="submit" value="REGISTER">
                @if (\Session::has('wrong'))
                <br>
                    <div class="alert alert-danger">
                        <p>{{\Session::get('wrong')}}</p>
                    </div>
                @endif
		    </form>
	    </div>
    </body>
</html>
