<!DOCTYPE html>
<html>
<head>
	<title>OP</title>
	<link href="../css/style3.css" rel='stylesheet' type='text/css'/>
	<link href="//fonts.googleapis.com/css?family=Ropa+Sans:400,400i&amp;subset=latin-ext" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />		<meta name="keywords" content="Simple Tab Forms Widget Responsive, Login Form Web Template, Flat Pricing Tables, Flat Drop-Downs, Sign-Up Web Templates, Flat Web Templates, Login Sign-up Responsive Web Template, Smartphone Compatible Web Template, Free Web Designs for Nokia, Samsung, LG, Sony Ericsson, Motorola Web Design" />
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

	<script src="../js/jquery.min.js"></script>
	<script type="text/javascript">	
		$(document).ready(function () {
		$('#horizontalTab').easyResponsiveTabs({
			type: 'default', //Types: default, vertical, accordion           
			width: 'auto', //auto or any width like 600px
			fit: true   // 100% fit in a container
			});
		});
	</script>
</head>
<body>
	<h1>OpenId Service</h1>
	<div class="main-content">
        <div class="right-w3">
			<div class="sap_tabs">	
				<div id="horizontalTab" style="display: block; width: 100%; margin: 0px;">
					<ul>
						<li class="resp-tab-item" aria-controls="tab_item-0" role="tab"><span>Create Credentials</span></li>
						<li class="resp-tab-item" aria-controls="tab_item-1" role="tab"><span>OAuth client</span></li>
				    <div class="clear"></div>
					</ul>	
					<div class="agile-tb">
						<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-0">
							<h2>OAuth Client ID for Web application</h2>
							<p>Yêu cầu sự đồng ý của người dùng để ứng dụng có thể truy cập dữ liệu</p>
							<!--form đăng ký app -->
							<form action="{{route('register-info')}}" method="post">
								@if($errors->any())
									<div class="alert alert-danger"> 
										<p> {{$errors->first()}} </p>
									</div>
								@endif
								<input type="hidden" name="_token" value="{{csrf_token()}}">				
								<input placeholder="Name Client" name="name_client" type="text" required="">
								<!-- URI chuyển hướng được ủy quyền-->
								<input placeholder="Authorized redirect URIs" name="url_redirect" type="text" required="">
								<input type="submit" name="create" value="Create">
							</form>
						</div>
						<div class="tab-2 resp-tab-content" aria-labelledby="tab_item-1">
							<!--form truy xuất thông tin đã lưu-->
							<form action="{{route('check-info')}}" method="post">
								<input type="hidden" name="_token" value="{{csrf_token()}}"/>				
								<input placeholder="App Name" name="key" type="text" required="" value="">
								<input type="submit" name='ok' value="Search">
								@if($errors->any())
									<div class="alert alert-danger"> 
										<p> {{$errors->first()}} </p>
									</div>
								@endif
								@if(!empty($info))
								<div>
									<p>Url Redirect: {{$info->url_redirect}}</p>
									<p>State: {{$info->state}}</p>
									<p>Client ID: {{$info->client_id}}</p>
									<p>Client Secrect: {{$info->client_secrect}}</p>
								</div>
								@endif
							</form>
						</div>
					 </div>
				</div> 
			</div> 			        					            	      
		</div>	
	</div>
	
	<script src="../js/easyResponsiveTabs.js" type="text/javascript"></script>
</body>
</html>