
@if (Session::has('hod'))
    <script>
        window.location="home";
    </script>
@endif

<!DOCTYPE HTML>
<html>
	<head>
		<title>Student & Staff Welfare System | HOD Home</title>
		<!--mobile apps-->
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		<!--mobile apps-->
		<!--Custom Theme files -->
			<link href="css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
			<link href="css/style.css" type="text/css" rel="stylesheet" media="all">
		<!-- //Custom Theme files -->
		<!-- js -->
			<script src="js/jquery-1.11.1.min.js"></script>
			<script type="text/javascript" src="vendor/jquery/jquery-1.10.2.min.js"></script>
			<script type="text/javascript" src="js/bootstrapValidator.js"></script>
		<!-- //js -->
		<!--web-fonts-->
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<!--//web-fonts-->
		<!--animate-->
			<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
			<script src="js/wow.min.js"></script>
			<script>
				new WOW().init();
            </script>
            <style type="text/css">
                #footer{
			        position:fixed;
			        bottom:0px;
			        right:0px;
			        left:0px;
                }
            </style>

			<script>
			function CheckUsername() {
        		var username=document.getElementById('username').value;
        		if(username.length!="")
        		{
					document.getElementById('ErrorUsername').innerHTML="";
            		document.getElementById("signin").disabled = false;
            		CheckPassword();
        		}
        		else{
            		document.getElementById('ErrorUsername').innerHTML="Username Field Should Not Be Empty!!";
            		document.getElementById("signin").disabled = true;
        		}
    		}

			function CheckPassword() {
        		var password=document.getElementById('password').value;
        		if(password.length=="")
        		{
            		document.getElementById('ErrorPassword').innerHTML="Password Field Should Not Be Empty!!";
            		document.getElementById("signin").disabled = true;
        		}
        		else{
            		document.getElementById('ErrorPassword').innerHTML="";
            		document.getElementById("signin").disabled = false;
            		CheckEnrollment();
        		}
    		}

			</script>
		<!--//end-animate-->
	</head>
	<body onLoad="document.getElementById('signin').disabled=true;">
		<!--banner-->
			<div  id="HodHome" class="banner">
				<div class="banner-info">
					<div class="banner-top">
						<div class="container">
							<div class="col-md-6 banner-top-left wow slideInDown animated" data-wow-delay=".5s">
									<p>HOD</p>
								{{-- <ul class="social-icons">
									<li><a href="#"> </a></li>
									<li><a href="#" class="fb"> </a></li>
								</ul> --}}
							</div>
						<div class="col-md-6 banner-top-right wow slideInDown animated" data-wow-delay=".5s">
                        <p><i class="fa fa-at"></i> sswsproject@outlook.com</p>
					</div>
					<div class="clearfix"> </div>
				</div>
			</div>
			<div class="banner-text">
				<h1 class="wow slideInLeft animated" data-wow-delay=".5s"><a href="/">SSWS</a></h1>
				{{-- <p class="wow slideInRight animated" data-wow-delay=".5s">Student & Staff Welfare System</p> --}}
			</div>
			<!--navigation-->
			<div class="top-nav wow">
				<div class="container">
					<div class="navbar-header logo">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							Menu
						</button>
					</div>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<div class="menu">
							<ul class="nav navbar">
								<li class="menu-item"><a href="#" class="menu-link scroll" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-lock"></i>Sign In</a></li>
							</ul>
						</div>
						<!--/Login-->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                </div>
                <div class="modal-body">
                    <div class="login px-4 mx-auto mw-100">
						<h3 class="text-center mb-4">Sign In</h5><br>
                        <form action="HodLogin" method="post">

							@if (\Session::has('wrong'))
                    			<div class="alert alert-danger">
									<script>
										$( document ).ready(function() {
											$('#exampleModalCenter').modal('show');
										});
									</script>
                        			<p align="center">{{\Session::get('wrong')}}</p>
                    			</div>
							@endif
						@csrf
                            <div class="form-group">
                                <label class="mb-2">Username</label>
								<input type="text" name="username" id="username" placeholder="" class="form-control" maxlength="12" onkeyup="CheckUsername()"/>
								<b>
									<span id="ErrorUsername" style="color: red"></span>
								</b>
                            </div>
                            <div class="form-group">
                                <label class="mb-2">Password</label>
								<input type="password" name="password" placeholder="" id="password" class="form-control" maxlength="32" onkeyup="CheckPassword()" />
								<b>
									<span id="ErrorPassword" style="color: red"></span>
								</b>
                            </div>
                            <button type="submit" class="btn btn-primary submit mb-4" id="signin">Sign In</button>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--//Login-->
    </div>
        <!-- copyright -->
        <footer id="footer">
		<div class="copy_right_w3ls py-4 text-center">
			<p>© 2018 Student & Staff Welfare System. All rights reserved</p>
		</div>
        <!-- //copyright -->
    </footer>
	</div>
	<!--//banner-->
	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap.js"></script>

</body>
</html>
