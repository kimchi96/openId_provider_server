<!DOCTYPE HTML>
<html>
<head>
<title>OP</title>
<!-- Custom Theme files -->
<link href="../css/style2.css" rel="stylesheet" type="text/css" media="all"/>
<!-- Custom Theme files -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta name="keywords" content="Square login form web template, Sign up Web Templates, Flat Web Templates, Login signup Responsive web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--Google Fonts-->
<link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
<!--Google Fonts-->
</head>
<body>
<!--header start here-->
<div class="login-form">
		<h1>REGISTER FORM</h1>
		<div class="login-top">
		<form action="#signup" method="post">
			@if($errors->any())
				<div class="alert alert-danger"> 
					<p> {{$errors->first()}} </p>
				</div>
			@endif
		  <input type="hidden" name="_token" value="{{csrf_token()}}"/>
		  <div class="login-ic1">
			<i ></i>
			<input placeholder="User name" name="username" type="text" required="">
			<div class="clear"> </div>
	      </div>
	      <div class="login-ic1">
				<i class="icon"></i>
				<input placeholder="Password" name="password" type="password" required="">
				<div class="clear"> </div>
		  </div>
		  <div class="login-ic1">
		  	<i class="icon0"></i>
		    <input placeholder="Name" name="name" type="text" required="">
		    <div class="clear"> </div>
		  </div>
		  <div class="login-ic1">
		  	<i class="icon1"></i>
		    <input placeholder="Email" name="email" type="email" required="">
		    <div class="clear"> </div>
		  </div>
		  <div class="login-ic1">
		  	<i class="icon2"></i>
		    <input placeholder="Address" name="address" type="text" required="">
		    <div class="clear"> </div>
		  </div>
		  <div class="login-ic1">
		  	<i class="icon3"></i>
		    <input placeholder="Phone Number" name="number" type="text" required="">
		    <div class="clear"> </div>
		  </div>
		  <div class="submit1">
		    <input type="submit" name="btnDangky" id="btnDangky" value="Register">
		    <div class="clear"> </div>
		  </div>
		</form>
		</div>
	</div>
</div>		
</body>
</html>