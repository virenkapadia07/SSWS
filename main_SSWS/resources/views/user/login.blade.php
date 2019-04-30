@if (Session::has('logged_in'))
    <script>
        window.location="home";
    </script>
@endif

@if (Session::has('admin'))
    <script>
        window.location="AdminHome";
    </script>
@endif

@if (Session::has('gatekeeper'))
    <script>
        window.location="GHome";
    </script>
@endif

<!DOCTYPE HTML>
<html>
	<head>
		<title>Student & Staff Welfare System | Home</title>
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
			function CheckEnrollment() {
        		var enrollment=document.getElementById('enrollment').value;
				var reg=/^\d{12}$/
        		if(reg.test(enrollment))
        		{
					document.getElementById('ErrorEnrollment').innerHTML="";
            		document.getElementById("signin").disabled = false;
            		CheckPassword();
        		}
        		else{
            		document.getElementById('ErrorEnrollment').innerHTML="Invalid Enrollment Number!!";
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

			function CheckEnrollment1() {
        		var enrollment=document.getElementById('enrollment1').value;
				var reg=/^\d{12}$/
        		if(reg.test(enrollment))
        		{
					document.getElementById('ErrorEnrollment1').innerHTML="";
            		document.getElementById("register").disabled = false;
            		CheckEmail();
        		}
        		else{
            		document.getElementById('ErrorEnrollment1').innerHTML="Invalid Enrollment Number!!";
            		document.getElementById("register").disabled = true;
        		}
    		}

			function CheckEmail() {
        		var email=document.getElementById('email').value;
				var reg=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        		if(reg.test(email))
        		{
					document.getElementById('ErrorEmail').innerHTML="";
            		document.getElementById("register").disabled = false;
            		CheckEnrollment1();
        		}
        		else{
            		document.getElementById('ErrorEmail').innerHTML="Invalid Email Address!!";
            		document.getElementById("register").disabled = true;
        		}
    		}

			function CheckEmail2() {
        		var email=document.getElementById('email2').value;
				var reg=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        		if(reg.test(email))
        		{
					document.getElementById('ErrorEmail2').innerHTML="";
            		document.getElementById("forgotpassword").disabled = false;
        		}
        		else{
            		document.getElementById('ErrorEmail2').innerHTML="Invalid Email Address!!";
            		document.getElementById("forgotpassword").disabled = true;
        		}
    		}

			function CheckOTP() {
        		var otp=document.getElementById('otp').value;
				var reg=/^\d{6}$/
        		if(reg.test(otp))
        		{
					document.getElementById('ErrorOTP').innerHTML="";
            		document.getElementById("verifyotp").disabled = false;
        		}
        		else{
            		document.getElementById('ErrorOTP').innerHTML="Invalid OTP!!";
            		document.getElementById("verifyotp").disabled = true;
        		}
    		}

			</script>
		<!--//end-animate-->
	</head>
	<body onLoad="document.getElementById('signin').disabled=true;
                  document.getElementById('register').disabled=true;
				  document.getElementById('forgotpassword').disabled=true;
				  document.getElementById('verifyotp').disabled=true;
				  document.getElementById('resendotp').disabled=true;">
		<!--banner-->
			<div  id="home" class="banner">
				<div class="banner-info">
					<div class="banner-top">
						<div class="container">
							<div class="col-md-6 banner-top-left wow slideInDown animated" data-wow-delay=".5s">
									<p>Student</p>
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
								<li class="menu-item"><a href="#" class="menu-link scroll" data-toggle="modal" data-target="#exampleModalCenter2"><i class="fa fa-user"></i>Register</a></li>
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
                        <form action="UserLogin" method="post">

							@if (\Session::has('wrong2'))
                    			<div class="alert alert-danger">
									<script>
										$( document ).ready(function() {
											$('#exampleModalCenter').modal('show');
											$('#exampleModalCenter2').modal('hide');
											$('#exampleModalCenter3').modal('hide');
										});
									</script>
                        			<p align="center">{{\Session::get('wrong2')}}</p>
                    			</div>
							@endif
							@if (\Session::has('success'))
								<div class="alert alert-success">
									<script>
										$( document ).ready(function() {
											$('#exampleModalCenter').modal('show');
											$('#exampleModalCenter2').modal('hide');
											$('#exampleModalCenter3').modal('hide');
										});
									</script>
									<p align="center">{{\Session::get('success')}}</p>
								</div>
							@endif
							@if (\Session::has('success1'))
								<div class="alert alert-success">
									<script>
										$( document ).ready(function() {
											$('#exampleModalCenter').modal('show');
											$('#exampleModalCenter3').modal('hide');
											$('#exampleModalCenter2').modal('hide');
										});
									</script>
									<p align="center">{{\Session::get('success1')}}</p>
								</div>
							@endif
						@csrf
                            <div class="form-group">
                                <label class="mb-2">Enrollment No.</label>
								<input type="text" name="enrollment" id="enrollment" placeholder="" class="form-control" maxlength="12" onkeyup="CheckEnrollment()"/>
								<b>
									<span id="ErrorEnrollment" style="color: red"></span>
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
                            <p class="text-center pb-4">
                                <a data-dismiss="modal" data-toggle="modal" href="#" data-target="#exampleModalCenter3">Forgot Password?</a>
                            </p><br>
							<p class="text-center pb-4">
                                <a data-dismiss="modal" data-toggle="modal" href="#" data-target="#exampleModalCenter2">New Here? Register!!</a>
                            </p>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--//Login-->
    <!--/Register-->
    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                </div>
                <div class="modal-body">
                    <div class="login px-4 mx-auto mw-100">
						<h3 class="text-center mb-4">Register Now</h5><br>
                        <form action="submitted" method="post">

							@if (\Session::has('wrong'))
								<div class="alert alert-danger">
									<script>
										$( document ).ready(function() {
											$('#exampleModalCenter2').modal('show');
											$('#exampleModalCenter').modal('hide');
											// $('#exampleModalCenter3').modal('hide');
										});
									</script>
									<p align="center">{{\Session::get('wrong')}}</p>
								</div>
							@endif
						@csrf
                            <div class="form-group">
                                <label>Enrollment No.</label>
								<input type="text" name="enrollment" id="enrollment1" placeholder="" class="form-control" maxlength="12" onkeyup="CheckEnrollment1()" />
								<b>
									<span id="ErrorEnrollment1" style="color: red"></span>
								</b>
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
								<input type="email" name="email" placeholder="" id="email" class="form-control" maxlength="32" onkeyup="CheckEmail()" />
								<b>
									<span id="ErrorEmail" style="color: red"></span>
								</b>
                            </div>
                            <button type="submit" class="btn btn-primary submit mb-4" id="register">Register Here</button>
							<p class="text-center pb-4">
                                <a data-dismiss="modal" data-toggle="modal" href="#" data-target="#exampleModalCenter">Already Registered? Sign In!!</a>
                            </p>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
	<!--//Register-->

	<!--/OTP-->
    <div class="modal fade" id="exampleModalCenter4" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                </div>
                <div class="modal-body">
                    <div class="login px-4 mx-auto mw-100">
						<h3 class="text-center mb-4">OTP Verification</h5><br>
                        <form action="otp" method="post">

								@if (\Session::has('successOTP'))
								<div class="alert alert-success">
									<script>
										$( document ).ready(function() {
											$('#exampleModalCenter4').modal('show');
											$('#exampleModalCenter').modal('hide');
											$('#exampleModalCenter2').modal('hide');
											$('#exampleModalCenter3').modal('hide');

										});
									</script>
									<p align="center">{{\Session::get('successOTP')}}</p>
								</div>
							@endif

							@if (\Session::has('wrong4'))
								<div class="alert alert-danger">
									<script>
										$( document ).ready(function() {
											$('#exampleModalCenter4').modal('show');
											$('#exampleModalCenter2').modal('hide');
											$('#exampleModalCenter').modal('hide');
											$('#exampleModalCenter3').modal('hide');
										});
									</script>
									<p align="center">{{\Session::get('wrong4')}}</p>
								</div>
							@endif

							@if (\Session::has('firstverify'))
								<div class="alert alert-danger">
									<script>
										$( document ).ready(function() {
											$('#exampleModalCenter4').modal('show');
											$('#exampleModalCenter2').modal('hide');
											$('#exampleModalCenter').modal('hide');
											$('#exampleModalCenter3').modal('hide');
										});
									</script>
									<p align="center">{{\Session::get('firstverify')}}</p>
								</div>
							@endif

						@csrf
                            <div class="form-group">
                                <label>OTP</label>
								<input type="text" name="otp" id="otp" placeholder="" class="form-control" maxlength="6" onkeyup="CheckOTP()" />
								<b>
									<span id="ErrorOTP" style="color: red"></span>
								</b>
                            </div>
							<button type="submit" class="btn btn-primary submit mb-4" id="verifyotp">Verify OTP</button>&nbsp;&nbsp;
							<button type="submit" class="btn btn-primary submit mb-4" id="resendotp" formaction="/resendotp">Resend OTP <span id="x">(</span><span id="timer"></span><span id="y">)</span></button>&nbsp;&nbsp;
						</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<!--//OTP-->


	<!--/Forget Password-->
    <div class="modal fade" id="exampleModalCenter3" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                </div>
                <div class="modal-body">
                    <div class="login px-4 mx-auto mw-100">
                        <h3 class="text-center mb-4">Forgot Password</h5><br>
                        <form action="forgotpassword" method="post">
							@if (\Session::has('wrong1'))
								<div class="alert alert-danger">
									<script>
										$( document ).ready(function() {
											$('#exampleModalCenter3').modal('show');
											$('#exampleModalCenter2').modal('hide');
											$('#exampleModalCenter1').modal('hide');
										});
									</script>
									<p align="center">{{\Session::get('wrong1')}}</p>
								</div>
							@endif
						@csrf
                            <div class="form-group">
                                <label>Email Address</label>
								<input type="email" name="email" placeholder="" id="email2" class="form-control" maxlength="32" onkeyup="CheckEmail2()" />
								<b>
									<span id="ErrorEmail2" style="color: red"></span>
								</b>
                            </div>
                            <button type="submit" class="btn btn-primary submit mb-4" id="forgotpassword">Reset Password</button>
							<p class="text-center pb-4">
                                <a data-dismiss="modal" data-toggle="modal" href="#" data-target="#exampleModalCenter">Sign In!!</a>
                            </p>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--//Forget Password-->
    </div>
		<!-- copyright -->
		<footer id="footer">
				<div class="copy_right_w3ls py-4 text-center">
					<p>© 2018 Student & Staff Welfare System. All rights reserved</p>
				</div>
				<!-- //copyright -->
			</footer>
		<!-- //copyright -->
	</div>
	<!--//banner-->
	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="js/bootstrap.js"></script>
	<script type="text/javascript">
		// countdown(30/30);
		// function countdown(minutes) {
		// 	var seconds = 30;
		// 	var mins = minutes;
		// 	function tick() {
		// 		var counter = document.getElementById("timer");
		// 		var current_minutes = mins-1;
		// 		seconds--;
		// 		counter.innerHTML = String(seconds);
		// 		if( seconds > 0 ) {
		// 			timeoutHandle=setTimeout(tick, 1000);
		// 		}
		// 	}
		// 	tick();
		// }

		let timerOn = true;
		function timer(remaining) {
			var s = remaining % 60;
			document.getElementById('timer').innerHTML = s;
			remaining -= 1;

			if(remaining >= 0 && timerOn) {
				setTimeout(function() {
					timer(remaining);
				}, 1000);
				return;
			}

			if(!timerOn) {
				document.getElementById('resendotp').disabled=true;
			}

		// Do timeout stuff here
		document.getElementById('resendotp').disabled=false;
		document.getElementById('timer').hidden=true;
		document.getElementById('x').hidden=true;
		document.getElementById('y').hidden=true;
		//alert('Timeout for otp');
		}
		timer(10);

		</script>

</body>
</html>
