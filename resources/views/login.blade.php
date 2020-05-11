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
	
			<div class="top-login">
				<span><img src="../images/group.png" alt=""/></span>
			</div>
			<h1>Login with OpenID</h1>
			<div class="login-top">
			<form action="" method="post"> 
				
				@if($errors->any())
					<div class="alert alert-danger"> 
						<p> {{$errors->first()}} </p>
					</div>
				@endif
				
				<input type="hidden" name="_token" value="{{csrf_token()}}"/>
				<div class="login-ic">
					<i ></i>
					<input name="username" type="text" id="username" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'User name';}"  value="User name"/>
					<div class="clear"> </div>
			  </div>
				<div class="login-ic">
					<i class="icon"></i>
					<input name="password" type="password" id="password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'password';}"  value="Password"/>
					<div class="clear"> </div>
				</div>
			
				<div class="log-bwn">
					<a href=""><input name="btnLogin" type="submit" id="btnLogin"  value="Login" >
				</div>
				<div class="register">
	                    <p>Don't Have an Account?   
							<a href="{{URL::route('register')}}">REGISTER NOW</a>
						</p>
                </div>
				</form>
			</div>
</div>		
<div id="test"></div>
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
</body>
<SCRIPT LANGUAGE="JavaScript">
	$(document).ready(function(){
		confirmAction()
	})
    function confirmAction() {
    	var search = window.location.search.split('&')
    	$('#btnLogin').click(function(e) {
    		e.preventDefault()
    		 confirm("Bạn có đồng ý đăng nhập OpenID với Website RP")
    		var username = $('[name="username"]').val()
    		var password = $('[name="password"]').val()
    		var token = $('[name="_token"]').val()
    		var state = search[3].split('=').pop()
    		var url_redirect = search[4].split('=').pop()
    		var client_id = search[2].split('=').pop()

    		$.ajax({
    		type:'post',
    		url:'./login',
    		data:{
    			_token:token,
    			username:username,
    			password:password,
    			state:state,
    			url_redirect:url_redirect,
    			client_id:client_id
    		},
    		success:function(data){
    			 window.opener.location.href = data
                    self.close()
    		}
    		})
    	})
     
    }
</SCRIPT>
</html>