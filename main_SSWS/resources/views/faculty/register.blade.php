<!DOCTYPE html>
@if (Session::has('logged_in'))
    <script>
        window.location="home";
    </script>
@endif
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Faculty Register</title>
        {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"> --}}
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" media="screen" href="css/particles_style.css">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="styles/shards-dashboards.1.1.0.min.css">
        <link rel="stylesheet" href="styles/extras.1.1.0.min.css">
        <link rel="stylesheet" href="style.css">

    </head>

    <style>
        .panel {
            position: fixed;
            width: 300px;
            height: 320px;
            top: 45%;
            left: 45%;
            box-sizing: border-box;
            margin: -110px 0px 0px -100px;
        }
    </style>
    <body>
        <div class="panel" style="display: block;">
            <div>
                <div class="card card-small blog-comments" style="border-radius: 5%">
                    <div class="card-header border-bottom" style="background-color: #fff;border-top-right-radius:50%;border-top-left-radius: 20%">
                        <h6 class="m-0">Faculty Register</h6>
                    </div>
                        <div class="card-body d-flex flex-column">
                        <form class="" action="doRegister" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control" id="facultyID" name="facultyID" placeholder="Faculty ID" required value="{{ old('facultyID') }}">
                                @if ($errors->has('facultyID'))
                                    <span style="color:red" role="alert">
                                        <strong>{{ $errors->first('facultyID') }}</strong>
                                    </span>
                                @endif
                                <b>
                                    <span id="ErrorFacultyID" style="color:red;margin-bottom:10px"></span>
                                </b>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span style="color:red" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <b>
                                    <span id="ErrorPassword" style="color: red"></span>
                                </b>
                            </div>
                            <div style="text-align:right;font-size: .8125rem">
                            <a style="color:#007bff" href='/'>Already Register!! Login Here</a>
                            </div>
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-accent" id="register" style="width:100%;margin-top:5px;color;background-color:#007bff;color:white">Register</button>
                            </div>
                            @if (\Session::has('wrong'))
                                <div class="alert alert-danger">
                                    <p>{{\Session::get('wrong')}}</p>
                                </div>
                            @endif

                            @if (\Session::has('success'))
                                <div class="alert alert-success">
                                    <p>{{\Session::get('success')}}</p>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="particles-js">

        </div>

        <!-- scripts -->
        <script src="js/particles.js"></script>
        <script src="js/particles_app.js"></script>
    </body>
</html>
